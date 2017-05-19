#!/usr/bin/ruby

# docker-compose exec app php artisan key:generate
# docker-compose exec app php artisan optimize
# docker-compose reload app
# docker-compose exec app php artisan migrate --seed
# docker run --rm -v $(pwd):/app composer/composer install

namespace :runner do
  desc "start docker"
  task :start do
    on roles(:all) do
      within release_path do
        next if test("[ cd #{release_path};docker-compose exec app echo 'hi' &> /dev/null && $? -eq 0 ]")
        execute "ls -al"
        execute "pwd"
        #execute "cd #{release_path};docker-compose up composer"
        execute "cd #{release_path};docker-compose up -d --build"
      end
    end
    Rake::Task["runner:start"].reenable

  end
  desc "stop docker"
  task :stop do
    on roles(:all) do
      within previous_release do
        execute "cd #{previous_release}; docker-compose down"
      end
    end
    Rake::Task["runner:stop"].reenable

  end
  desc "reload docker"
  task :reload do
    on roles(:all) do
      Rake::Task["runner:end"].invoke()
      Rake::Task["runner:start"].invoke()
    end
    Rake::Task["runner:reload"].reenable

  end
  desc "npm install"
  task :npm do
    on roles(:all) do
      within release_path do
        execute "cd #{release_path};docker-compose run --rm node npm install"
      end
    end
  end
  desc "Maintenenance down"
  task :set_maintenance_mode_off do
    on roles(:all) do
      within release_path do
        Rake::Task["runner:artisan"].invoke("up")
      end
    end
  end
  desc "Maintenance up"
  task :set_maintenance_mode_on do
    on roles(:all) do
      within release_path  do
        Rake::Task["runner:artisan"].invoke("down")
      end
    end
  end
  desc "Run artisan command"
  task :artisan do |_t, args|
    # ask(:cmd, "list") # Ask only runs if argument is not provided
    #command = args[:command_name]# || fetch(:cmd)

    on roles fetch(:all) do
      within release_path do
        if test('[ ! -d "vendor" ]')
          Rake.Task["runner:composer"].invoke()
          #execute "cd #{release_path};docker-compose up composer"
        end
        execute "cd #{release_path};docker-compose run --rm app php artisan ", *args.extras
      end
    end

    # Enable task artisan to be ran more than once
    Rake::Task["runner:artisan"].reenable
  end
  desc "Ensure that linked dirs exist."
  task :ensure_linked_dirs_exist do
    on roles(:app) do
      fetch(:linked_dirs).each do |path|
        within shared_path do
          execute :mkdir, "-p", path
        end
      end
    end
  end

  desc "Ensure that ACL paths exist."
  task :ensure_acl_paths_exist do

    on roles(:app) do
      fetch(:file_permissions_paths).each do |path|
        within release_path do
          execute :mkdir, "-p", path
        end
      end
    end
  end

  desc "Storage"
  task :storage do
    on roles(:app) do
      within "#{release_path}" do
        Rake::Task["runner:artisan"].invoke("storage:link")
      end
    end
  end
  desc "Artisan optimize"
  task :optimize do
      on roles(:all) do
        Rake::Task["runner:artisan"].invoke("clear-compiled")
        Rake::Task["runner:artisan"].invoke(:optimize, "--force")
      end
  end
  desc "Copy env on remote"
  task :copy_env do
    on roles(:all) do
      within release_path do
        next if test("[ -f #{release_path}/.env ]")
        execute "cp #{release_path}/.env.example #{release_path}/.env"
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
        execute "ls -al"
        execute "pwd"
        # execute "cd #{release_path};docker run --rm $(pwd):/app composer/composer install --no-scripts"
        execute "cd #{release_path};docker-compose up composer"
      end
    end
  end
end
# after "deploy:updating", "runner:start"
# after "deploy:finished", "runner:set_maintenance_mode_on"
# after  "deploy:published",  "runner:composer"
before 'deploy:updated', 'runner:composer'
before 'deploy:reverted', 'runner:composer'
after  "deploy:published",  "runner:npm"
before "runner:start", "runner:composer"
after  "deploy:published", "runner:reload"
# before "deploy:reverting", "runner:migrate_rollback"
after  "deploy:starting", "runner:ensure_linked_dirs_exist"
after  "deploy:updating", "runner:ensure_acl_paths_exist"
before "deploy:updated",  "deploy:set_permissions:acl"

before "runner:composer", "runner:copy_env"
after "runner:composer", "runner:app_key"
after  "runner:composer", "runner:storage"
# after  "runner:composer", "runner:storage_acl"
after  "runner:composer",  "runner:optimize"
