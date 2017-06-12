# Permissions

The app currently has permissions for starting and stopping runs.
The app should have everything regulated by permissions.

If you want to add permissions, do it in the RoleSeeder, and then implement them in your controllers.

# Settings

As of right now settings aren't cache. That's a huge performance dump.

The app should have a `SettingsRepository`, that get's settings from cache, or from the database, or config


# UI components
## Dashboard
Enable the front-end to change some hard-coded settings such as :
- Database reset
- Change the avaiable groups colors
## Kiela
## Schedule
## Groups