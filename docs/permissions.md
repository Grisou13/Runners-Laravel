# Permissions

In the context of this app, the api part implements permissions.

This is done with the help of the `spatie/laravel-permission`.

The basic usage is
```
$user->hasPermissionTo('DO SOEMTHING');
```

Here is the list of available permissions:

| Permission name | Role               | Description |
|-----------------|--------------------|-------------|
| end run         | admin, coordinator |             |
| start run       | admin, coordinator |             |
| force run end   | admin, coordinator |             |
| force run start | admin, coordinator |             |
| view runs       | admin, coordinator |             |
| edit settings   | admin, coordinator |             |
| create settings | admin, coordinator |             |
| delete settings | admin, coordinator |             |

## Adding permissions

To add permissions, please do it in `RoleSeeder`.
And then execute `php artisan db:reset`.

It's the simplest way. Please refer to the [spatie/laravel-permission documentation](https://github.com/spatie/laravel-permission) for any further help.