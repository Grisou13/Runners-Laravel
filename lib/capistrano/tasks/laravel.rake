#!/usr/bin/ruby

# docker-compose exec app php artisan key:generate
# docker-compose exec app php artisan optimize
# docker-compose reload app
# docker-compose exec app php artisan migrate --seed
# docker run --rm -v $(pwd):/app composer/composer install

  namespace :runner do
    desc "Reload docker"
    task :reload do
      on roles(:all) do
        within previous_release do
          execute "docker-compose down"
        end
        within current_release do
          execute "docker-compose up"
        end
      end
    end
    desc "npm install"
    task :npm do
      on roles(:all) do
        within release_path do
          execute "docker-compose up node"
        end
      end
    end
    desc "Maintenenance down"
    task :set_maintenance_mode_off do
      on roles(:all) do
        within current_path do
          Rake::Task["runner:artisan"].invoke("up")
        end
      end
    end
    desc "Maintenance up"
    task :set_maintenance_mode_on do
      on roles(:all) do
        within current_path  do
          Rake::Task["runner:artisan"].invoke("down")
        end
      end
    end
    task :install do
        #composer + migrate + scheduler + queue worker
    end
    desc "Run artisan command"
    task :artisan, [:command_name] do |_t, args|
      # ask(:cmd, "list") # Ask only runs if argument is not provided
      command = args[:command_name]# || fetch(:cmd)

      on roles fetch(:all) do
        within release_path do
          execute "docker-compose exec app php artisan ", *args.extras
        end
      end

      # Enable task artisan to be ran more than once
      Rake::Task["runner:artisan"].reenable
    end
    desc "Storage acl"
    task :acl_storage do
      on roles(:app) do
          execute "sudo chown -R deploy:deploy #{latest_release}/"
          [
          "bootstrap/cache",
          "storage",
          "storage/app",
          "storage/app/public",
          "storage/framework",
          "storage/framework/cache",
          "storage/framework/sessions",
          "storage/framework/views",
          "storage/logs"
        ].each_char { |k,v| execute "sudo chmod -R 777 #{latest_release}/#{v}"  }

      end
    end
    desc "Storage"
    task :storage do
      on roles(:app) do
        within "#{current_path}" do
          Rake::Task["runner:artisan"].invoke("storage:link")
        end
      end
    end
    desc "Artisan optimize"
    task :optimize do
        on roles(:all) do
          Rake::Task["runner:artisan"].invoke(:optimize, "--force")
        end
    end

    desc "Copy env on remote"
    task :copy_env do
      on roles(:app) do
        within release_path do
          next if test("[ -f #{release_path}/.env ]")
          execute "cp .env.example .env"
        end
      end
    end
    desc "Gen app key"
    task :app_key do
      on roles(:app) do
        within release_path do
          Rake::Task["runner:artisan"].invoke("key:generate")
        end
      end
    end
    desc "Upload dotenv file for release."
    task :upload_dotenv_file do
      dotenv_file = "./.env"

      run_locally do
        if dotenv_file.empty? || test("[ ! -e #{dotenv_file} ]")
          raise Capistrano::ValidationError, "Must prepare dotenv file [#{dotenv_file}] locally before deploy!"
        end
      end

      on roles fetch(:app) do
        upload! dotenv_file, "#{release_path}/.env"
      end
    end
    desc "Migrate"
    task :migrate do
      on roles(:app) do
        Rake::Task["runner:artisan"].invoke(:migrate, "--force --env=#{fetch(:stage)}")
      end
    end

    desc "Rollback the last database migration."
    task :migrate_rollback do
      on roles(:app) do
        Rake::Task["runner:artisan"].invoke("migrate:rollback", "--force --env=#{fetch(:stage)}")
      end
    end
    desc "Install composer."
    task :composer do
      on roles(:all) do
        within release_path do
          execute "docker run --rm -v $(pwd):/app composer/composer install"
        end
      end
    end
  end
  before "deploy:starting", "runner:set_maintenance_mode_on"
  after "deploy:finished", "runner:set_maintenance_mode_on"
  after  "deploy:finishing",  "runner:composer"
  after  "deploy:finishing",  "runner:npm"
  after "deploy:finished", "runner:reload"
  before "deploy:reverting", "runner:migrate_rollback"

  before "runner:composer", "runner:copy_env"
  before "runner:composer", "runner:app_key"
  after  "runner:composer", "runner:storage_link"
  after  "runner:composer", "runner:storage_acl"
  after  "runner:composer",  "runner:optimize"
