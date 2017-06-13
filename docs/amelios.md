# Permissions

The app currently has permissions for starting and stopping runs.
The app should have everything regulated by permissions.

If you want to add permissions, do it in the RoleSeeder, and then implement them in your controllers.

# Settings

As of right now settings aren't cache. That's a huge performance dump.

The app should have a cached version of the settings, use a database model if nothing is found. As a last resort, use the configs if nothing was found.


# UI components
## Dashboard
Enable the front-end to change some hard-coded settings such as :
- Database reset
- Change the avaiable groups colors
- Change icons for customisation
- Allow permission assignement

## Kiela
## Schedule
## Groups

# Roles

As of right now the default created users are only `runners`

The ui doesn't provide anything to assign roles to users!!! Not good!!! Bad.

As of right now, nothing was discussed, but the best thing would be to do it when inserting a user.
If it is done with the weird seeders, than that would be up to the developer to find a way.

# Stats

There is nothing done for this right now. What needs to be done is a graph endpoint. It should allows for flexible querying on different models, count columns, etc..
We were thinking something like
/statstic/{model}?columns=[columns seperated by',']&count=[columns to count]
 
Or the best for this would just be GRAPHQL. But Eh, you can't have everything can you?

But maybe you could just use the client and [reselect](https://github.com/reactjs/reselect) to create an intelligent selector for the data.

# Statuses
 
Implement statuses in the database. This allows the user to be flexible with the names.
It must also use a "weighting" system to determine which status should go before another ("raedy"<"gone", atleast it should be the case). 

# Modals
 
As of right now, we created validation rules. But the UI doesn't have any validation. It would be nice to atleast indecate which fields are required with an asterix.
 
# Runs
 
The first thing that needs to be done is add multi stage creation for the run.
The fact the app is built with react is a big step forward already.
This means that when creating a run, the app should ask for a name, date, etc... then ask to add people.
This allows the ui to display users that are going to be present, and are free at the declared time of the run.
And when finishing give the user a recap page and tell them they can change later.
 
The second thing would be a fast edit option to add people, adn change dates directly from the list.
This allows coordinators to be much faster in their job. 
If they need to insert waypoints, or anything else much more complex than a simple update, they can still go to the basic UI.
 
# Location tracking

This would be a very cool feature to have. It would allow the run list view to be much more dynamic and automatise alot of the stuff.
It's almost simple to do. As of right now you would need to create a couple events to trigger when the locaiton of a user is updated.
Then you would simply hand those events to broadcast

the endpoint to receive location updates would be ssomething like POST /users/location `{lat:[stuff], lng:[stuff], ...more}`
And on update trigger an event to broadcast.

Now you would need to modify the runners app a bit to watch location and submit it to the api.

The tricky part comes in the app, where the app should keep the screen awake and watch position.

# Unit and integration testing

Hey, how about some tests?

Weow we didn't really have time. We implemented some tests for the api, but nothing on the app is unit tested.

This should be done, so that deployement in production is always stable.
