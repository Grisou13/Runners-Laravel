# Api
There will soon be a swagger that will make a very pretty docs, but for now here's a brief summary.

# Accessible

The api is accessible at the suffix ``` api/ ```. This is configured in the ```.env``` so just be sure it matches.

# Authentication

To authenticate with the api you may use 3 methods : 
 - ```token=ACCESSTOKEN``` in the query string
 - ```X-Access-Token=ACCESSTOKEN``` header in the request
 - ``` Authorization: x-acces-token ACCESSTOKEN ``` header in the request
 
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