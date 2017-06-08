# Permissions

The app currently has permissions for starting and stopping runs.
The app should have everything regulated by permissions.

If you want to add permissions, do it in the RoleSeeder, and then implement them in your controllers.

# Settings

As of right now settings aren't cache. That's a huge performance dump.

The app should have a `SettingsRepository`, that get's settings from cache, or from the database, or config

# Statistique

There is nothing done for this right now. What needs to be done is a graph endpoint. It should allows for flexible querying on different models, count columns, etc..
 We were thinking something like
 /statstic/{model}?columns=[columns seperated by',']&count=[columns to count]
 
 # Statuses
 
 Implement statuses in the database. This allows the user to be flexible with the names.
 It must also use a "weighting" system to determine which status should go before another ("raedy"<"gone", atleast it should be the case).