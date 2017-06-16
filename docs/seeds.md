# Basic usage

Seeds allow the database to be populated. The runners app requires some data to be installed before using the app.

This is why there is a `BaseSeeder`. This seeder calls the minimal seeding necessary for the app to work.
You can use it by doing `php artisan db:seed --class=BaseSeeder`
By default BaseSeeder creates:
- Roles and Permissions
- Settings

Then there is `DatabaseSeeder`, which will call `BaseSeeder` and other dummy data seeders.
This is the default seeder launched by laravel!

Finally there is `ProductionSeeder`. This class contains real user data. It also calls `BaseSeeder`.
You can use it by doing `php artisan db:seed --class=ProductionSeeder`.

## Using with db:reset

The `db:reset` command runs seeding if not provided `--no-seed`.
