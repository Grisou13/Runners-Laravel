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

The update method on a group must contain a parameter ```ùser=ID```. It represents a user id.

# Query string parameters

There are a number of useful parameters that you can enter to filter your request.
They were implemented using the module [laravel-api-query-builder](https://github.com/selahattinunlu/laravel-api-query-builder) (for more information, please visit their wiki).

### order_by

**Parameters** (String column, String direction) or (String "random")

**Default** id,desc

**Example:** `?order_by=id,desc`, `?order_by=random`

---

### group_by

**Parameters** (String groups)

**Default** -

**Example:** `?group_by=id,name,....`

---

### limit

**Parameters** (Integer limit or String 'unlimited')

**Default** 15

**Example** ?limit=5, ?limit=unlimited

---

### page

**Parameters** (Integer page)

**Default** 1

**Example** ?page=3

---

### columns

select columns

**Parameters** (String columns)

**Default** *

**Examples** 
- ?columns=name,age,id
- ?columns=*,city.id,city.name,country.name

---

### includes

Eager Loading. 

**Parameters** (String includes)

**Default** []

**Example** ?includes=city,country,town

---

### appends

This will add the given values to Model's appends property as dynamically
https://laravel.com/docs/5.3/eloquent-serialization#appending-values-to-json

**Parameters** (String appends)

**Default** []

**Examples** 
- ?appends=is_admin,balance

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
