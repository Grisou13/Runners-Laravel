# config valid only for current version of Capistrano
lock "3.8.1"

set :application, "runners-laravel"
set :repo_url, "git@github.com:CPNV-ES/Runners-Laravel.git"

# Default branch is :master
# ask :branch, `git rev-parse --abbrev-ref HEAD`.chomp

# Default deploy_to directory is /var/www/my_app_name
# set :deploy_to, "c:/Apache24/htdocs/runners-laravel"

# Default value for :format is :airbrussh.
# set :format, :airbrussh

# You can configure the Airbrussh format using :format_options.
# These are the defaults.
# set :format_options, command_output: true, log_file: "log/capistrano.log", color: :auto, truncate: :auto

# Default value for :pty is false
# set :pty, true

# Default value for :linked_files is []
# append :linked_files, "config/database.yml", "config/secrets.yml"
append :linked_dirs,
      "storage/app",
      "storage/framework/cache",
      "storage/framework/sessions",
      "storage/framework/views",
      "storage/logs"

# Default value for linked_dirs is []
set :linked_dirs, fetch(:linked_dirs, []).push('storage')

set :file_permissions_paths, [
  "bootstrap/cache",
  "storage",
  "storage/app",
  "storage/app/public",
  "storage/framework",
  "storage/framework/cache",
  "storage/framework/sessions",
  "storage/framework/views",
  "storage/logs"
]
set :file_permissions_groups, ["deploy"]
set :file_permissions_users, ["deploy"]
set :file_permissions_chmod_mode, "0775"
desc "Ensure directories exists"
task :ensure_storage_exists do
  fetch(:file_permissions_paths,[]).each_char do |p|
    within shared_path do
      execute 'mkdir -p #{release_path}/#{p}'
    end
  end
end

set :branch, ENV['BRANCH'] if ENV['BRANCH']

before "deploy:set_permissions:acl", "runner:storage"
after "deploy:set_permissions:acl", "ensure_storage_exists"

before "deploy:finishing", "deploy:set_permissions:acl"

# Default value for default_env is {}
# set :default_env, { path: "/opt/ruby/bin:$PATH" }

# Default value for keep_releases is 5
# set :keep_releases, 5
