# Api

For the list of complete urls for the app, please visit the endpoint `/api`.
This view will list any route you may need, and the purpose of it.

This doc will details more the behind the scenes.

# How the api works in general

The api uses a module called `dingo/api`. 
This module adds a number of very usefull features to the standard Api declaration of Laravel

Workflow:

TODO create uml workflow registration


# Authentication

To authenticate with the api you may use 3 methods : 
 - ```token=ACCESSTOKEN``` in the query string
 - ```X-Access-Token=ACCESSTOKEN``` header in the request
 - ``` Authorization: x-acces-token ACCESSTOKEN ``` header in the request
 
 The access token comes from the `Lib\Models\User` model. This modal stores a special `accesstoken` field.
 If no token matches, the api throws a 403 Unauthorized.
 
 The you need to change anything with auth on the api take a look in `api/ApiAuthProvider`.
 __This is not a laravel service provider__
 
 
## Getting an access token

The default access token, and used right now to debug is ```root```.
This token will allow you to get anywhere in the api because the user is an admin

# Special URLS


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


# Creating a new ressource

Here's a small tutorial on how to create a new ressource, a new model interaction with the api.

## Create your model

You need to create your model and table first. Now do that
 
 ```
 php artisan make:model Profile --migration
 ```
 
 Now complete the migration file created `create_profile_table`
 
 And run `php artisan db_reset --production`
 
 To stay coherant with model logic, you should move your model RIGHT NOW from `app/Profile` to `lib/Models/Profile`
 
 For more details on why models are in `lib/`, [please check out the docs](models.md)
 
## Create your controller

First of lets create the file `api/Controllers/V1/ProfileController`

```
<?php

namespace Api\Controllers\V1;

use Api\Controllers\BaseController;
use Lib\Models\Profile;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class ProfileController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        return Profile::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       return Setting::create($request->except(["token","_token"]));
    }
  
  /**
   * Display the specified resource.
   *
   * @param Profile $profile
   * @return \Illuminate\Http\Response|Profile
   */
    public function show(Profile $profile)
    {
        return $profile;
    }
  
  
  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @param Profile $profile
   * @return \Illuminate\Http\Response|Setting
   */
    public function update(Request $request, Profile $profile)
    {
        $profile->update($request->except(["token","_token"]));
        return $settings;
    }
  
  /**
   * Remove the specified resource from storage.
   *
   * @param Profile $profile
   * @return \Illuminate\Http\Response
   */
    public function destroy(Profile $profile)
    {
      $profile->delete();
    }
}
```

That's it, you now have the basics of a working controller.

## Register your controller in your routes

Now that the controller is done, you still can't access it because it isn't registered in any routes.

Let's fix that shall we.

open up `api/routes.php`

and add
```
...
$api->group(["middleware"=>["api.auth"]],function(Dingo\Api\Routing\Router $api){
    ....
    $api->resource("profile","ProfileController");
    ....

```

And that's it, now ou can access it through `/api/profile`.

