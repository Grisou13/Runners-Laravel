# Api

For the list of complete urls for the app, please visit the endpoint `/api`.
This view will list any route you may need, and the purpose of it.

This doc will details more the behind the scenes.

# Authentication

To authenticate with the api you may use 3 methods : 
 - ```token=ACCESSTOKEN``` in the query string
 - ```X-Access-Token=ACCESSTOKEN``` header in the request
 - ``` Authorization: x-acces-token ACCESSTOKEN ``` header in the request
 
 The access token comes from the `Lib\Models\User` model. This modal stores a special `accesstoken` field.
 If no token matches, the api throws a 403 Unauthorized.
 
## Getting an access token

The default access token, and used right now to debug is ```root```.
This token will allow you to get anywhere in the api, as there is no permission system implemented yet!

# Special URLS

## groups
The update method on a group must contain a parameter ```ùser=ID```. It represents a user id.

# Request Examples
Get the list of users
```curl -X GET http://localhost/api/users?token=root```

Get the user that has the token
```curl -X GET http://localhost/api/users/me?token=root```

Get the list of runs
```curl -X GET http://localhost/api/runs?token=root```

Get the list of groups
```curl -X GET http://localhost/api/groups?token=root```

Get the list of cars
```curl -X GET http://localhost/api/cars?token=root```

# What happens to models?

If you see the data model, and the database, you will recognise that the api doesn't serve the same representation.

That is due to an addition of an abstract layer called Transformers.
Transformers allow the api to render a piece of data, and altering it only to render. Allowing the app to remain intact with it's data usage.

Now that can complicate a bit things sometimes (just check out the runs).

If you want to check out a transformer for a model, it will be in `api/Responses/Transformers`.

If you created a Transformer and need to register it. Do it in the `api/ApiServiceProvider` under `registerModelBindings`.

To create a transformer, you can inspire yourself from existing models. And if that doesn't suffice, visit [the transformer docs](http://fractal.thephpleague.com/transformers/)
