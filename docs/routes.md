# Api

Most of the api routes are protected, don't forget it, or you may have alooot of problems!

+------+-----------+----------------------------------------------+----------------------------+---------------------------------------------------------+-----------+------------+----------+------------+
| Host | Method    | URI                                          | Name                       | Action                                                  | Protected | Version(s) | Scope(s) | Rate Limit |
+------+-----------+----------------------------------------------+----------------------------+---------------------------------------------------------+-----------+------------+----------+------------+
|      | GET|HEAD  | /api                                         |                            | Api\Controllers\V1\HomeController@home                  | No        | v1         |          |            |
|      | GET|HEAD  | /api/ping                                    |                            | Api\Controllers\V1\HomeController@ping                  | No        | v1         |          |            |
|      | GET|HEAD  | /api/users                                   | users.index                | Api\Controllers\V1\UserController@index                 | Yes       | v1         |          |            |
|      | POST      | /api/users                                   | users.store                | Api\Controllers\V1\UserController@store                 | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/users/{user}                            | users.show                 | Api\Controllers\V1\UserController@show                  | Yes       | v1         |          |            |
|      | PUT|PATCH | /api/users/{user}                            | users.update               | Api\Controllers\V1\UserController@update                | Yes       | v1         |          |            |
|      | DELETE    | /api/users/{user}                            | users.destroy              | Api\Controllers\V1\UserController@destroy               | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/users/{user}/image                      | user.image                 | Api\Controllers\V1\UserController@image                 | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/users/{user}/runs                       |                            | Api\Controllers\V1\UserController@run                   | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/users/{user}/group                      |                            | Api\Controllers\V1\UserController@group                 | Yes       | v1         |          |            |
|      | PUT|PATCH | /api/users/{user}/group/{group}              |                            | Api\Controllers\V1\UserController@updateGroup           | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/groups/{group}/schedules                | groups.schedules.index     | Api\Controllers\V1\GroupScheduleController@index        | Yes       | v1         |          |            |
|      | POST      | /api/groups/{group}/schedules                | groups.schedules.store     | Api\Controllers\V1\GroupScheduleController@store        | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/groups/{group}/schedules/{schedule}     | groups.schedules.show      | Api\Controllers\V1\GroupScheduleController@show         | Yes       | v1         |          |            |
|      | PUT|PATCH | /api/groups/{group}/schedules/{schedule}     | groups.schedules.update    | Api\Controllers\V1\GroupScheduleController@update       | Yes       | v1         |          |            |
|      | DELETE    | /api/groups/{group}/schedules/{schedule}     | groups.schedules.destroy   | Api\Controllers\V1\GroupScheduleController@destroy      | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/schedules                               | schedules.index            | Api\Controllers\V1\ScheduleController@index             | Yes       | v1         |          |            |
|      | POST      | /api/schedules                               | schedules.store            | Api\Controllers\V1\ScheduleController@store             | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/schedules/{schedule}                    | schedules.show             | Api\Controllers\V1\ScheduleController@show              | Yes       | v1         |          |            |
|      | PUT|PATCH | /api/schedules/{schedule}                    | schedules.update           | Api\Controllers\V1\ScheduleController@update            | Yes       | v1         |          |            |
|      | DELETE    | /api/schedules/{schedule}                    | schedules.destroy          | Api\Controllers\V1\ScheduleController@destroy           | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/users/me                                | users.me                   | Api\Controllers\V1\AuthenticatedUserController@me       | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/users/me/runs                           |                            | Api\Controllers\V1\AuthenticatedUserController@runs     | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/users/me/schedule                       |                            | Api\Controllers\V1\AuthenticatedUserController@schedule | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/groups                                  | groups.index               | Api\Controllers\V1\GroupController@index                | Yes       | v1         |          |            |
|      | POST      | /api/groups                                  | groups.store               | Api\Controllers\V1\GroupController@store                | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/groups/{group}                          | groups.show                | Api\Controllers\V1\GroupController@show                 | Yes       | v1         |          |            |
|      | PUT|PATCH | /api/groups/{group}                          | groups.update              | Api\Controllers\V1\GroupController@update               | Yes       | v1         |          |            |
|      | DELETE    | /api/groups/{group}                          | groups.destroy             | Api\Controllers\V1\GroupController@destroy              | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/cars                                    | cars.index                 | Api\Controllers\V1\CarController@index                  | Yes       | v1         |          |            |
|      | POST      | /api/cars                                    | cars.store                 | Api\Controllers\V1\CarController@store                  | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/cars/{car}                              | cars.show                  | Api\Controllers\V1\CarController@show                   | Yes       | v1         |          |            |
|      | PUT|PATCH | /api/cars/{car}                              | cars.update                | Api\Controllers\V1\CarController@update                 | Yes       | v1         |          |            |
|      | DELETE    | /api/cars/{car}                              | cars.destroy               | Api\Controllers\V1\CarController@destroy                | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/status                                  |                            | Api\Controllers\V1\StatusController@index               | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/status/{model}                          |                            | Api\Controllers\V1\StatusController@model               | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/waypoints                               | waypoints.index            | Api\Controllers\V1\WaypointController@index             | Yes       | v1         |          |            |
|      | POST      | /api/waypoints                               | waypoints.store            | Api\Controllers\V1\WaypointController@store             | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/waypoints/{waypoint}                    | waypoints.show             | Api\Controllers\V1\WaypointController@show              | Yes       | v1         |          |            |
|      | PUT|PATCH | /api/waypoints/{waypoint}                    | waypoints.update           | Api\Controllers\V1\WaypointController@update            | Yes       | v1         |          |            |
|      | DELETE    | /api/waypoints/{waypoint}                    | waypoints.destroy          | Api\Controllers\V1\WaypointController@destroy           | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/search/{model}                          |                            | Api\Controllers\V1\SearchController@fullText            | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/runs                                    | runs.index                 | Api\Controllers\V1\Runs\RunController@index             | Yes       | v1         |          |            |
|      | POST      | /api/runs                                    | runs.store                 | Api\Controllers\V1\Runs\RunController@store             | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/runs/{run}                              | runs.show                  | Api\Controllers\V1\Runs\RunController@show              | Yes       | v1         |          |            |
|      | PUT|PATCH | /api/runs/{run}                              | runs.update                | Api\Controllers\V1\Runs\RunController@update            | Yes       | v1         |          |            |
|      | DELETE    | /api/runs/{run}                              | runs.destroy               | Api\Controllers\V1\Runs\RunController@destroy           | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/runs/{run}/waypoints                    | runs.waypoints.index       | Api\Controllers\V1\Runs\WaypointController@index        | Yes       | v1         |          |            |
|      | POST      | /api/runs/{run}/waypoints                    | runs.waypoints.store       | Api\Controllers\V1\Runs\WaypointController@store        | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/runs/{run}/waypoints/{waypoint}         | runs.waypoints.show        | Api\Controllers\V1\Runs\WaypointController@show         | Yes       | v1         |          |            |
|      | PUT|PATCH | /api/runs/{run}/waypoints/{waypoint}         | runs.waypoints.update      | Api\Controllers\V1\Runs\WaypointController@update       | Yes       | v1         |          |            |
|      | DELETE    | /api/runs/{run}/waypoints/{waypoint}         | runs.waypoints.destroy     | Api\Controllers\V1\Runs\WaypointController@destroy      | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/runs/{run}/car_types                    | runs.car_types.index       | Api\Controllers\V1\Runs\CarTypeController@index         | Yes       | v1         |          |            |
|      | POST      | /api/runs/{run}/car_types                    | runs.car_types.store       | Api\Controllers\V1\Runs\CarTypeController@store         | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/runs/{run}/car_types/{car_type}         | runs.car_types.show        | Api\Controllers\V1\Runs\CarTypeController@show          | Yes       | v1         |          |            |
|      | PUT|PATCH | /api/runs/{run}/car_types/{car_type}         | runs.car_types.update      | Api\Controllers\V1\Runs\CarTypeController@update        | Yes       | v1         |          |            |
|      | DELETE    | /api/runs/{run}/car_types/{car_type}         | runs.car_types.destroy     | Api\Controllers\V1\Runs\CarTypeController@destroy       | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/runs/{run}/cars                         | runs.cars.index            | Api\Controllers\V1\Runs\CarController@index             | Yes       | v1         |          |            |
|      | POST      | /api/runs/{run}/cars                         | runs.cars.store            | Api\Controllers\V1\Runs\CarController@store             | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/runs/{run}/cars/{car}                   | runs.cars.show             | Api\Controllers\V1\Runs\CarController@show              | Yes       | v1         |          |            |
|      | PUT|PATCH | /api/runs/{run}/cars/{car}                   | runs.cars.update           | Api\Controllers\V1\Runs\CarController@update            | Yes       | v1         |          |            |
|      | DELETE    | /api/runs/{run}/cars/{car}                   | runs.cars.destroy          | Api\Controllers\V1\Runs\CarController@destroy           | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/runs/{run}/users                        | runs.users.index           | Api\Controllers\V1\Runs\UserController@index            | Yes       | v1         |          |            |
|      | POST      | /api/runs/{run}/users                        | runs.users.store           | Api\Controllers\V1\Runs\UserController@store            | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/runs/{run}/users/{user}                 | runs.users.show            | Api\Controllers\V1\Runs\UserController@show             | Yes       | v1         |          |            |
|      | PUT|PATCH | /api/runs/{run}/users/{user}                 | runs.users.update          | Api\Controllers\V1\Runs\UserController@update           | Yes       | v1         |          |            |
|      | DELETE    | /api/runs/{run}/users/{user}                 | runs.users.destroy         | Api\Controllers\V1\Runs\UserController@destroy          | Yes       | v1         |          |            |
|      | POST      | /api/runs/{run}/start                        | run.start                  | Api\Controllers\V1\Runs\RunController@start             | Yes       | v1         |          |            |
|      | POST      | /api/runs/{run}/stop                         | run.stop                   | Api\Controllers\V1\Runs\RunController@stop              | Yes       | v1         |          |            |
|      | POST      | /api/runs/{run}/cars/{car}/join              |                            | Api\Controllers\V1\Runs\CarController@join              | Yes       | v1         |          |            |
|      | DELETE    | /api/runs/{run}/cars/{car}/unjoin            |                            | Api\Controllers\V1\Runs\CarController@unjoin            | Yes       | v1         |          |            |
|      | POST      | /api/runs/{run}/users/{user}/join            |                            | Api\Controllers\V1\Runs\UserController@join             | Yes       | v1         |          |            |
|      | DELETE    | /api/runs/{run}/users/{user}/unjoin          |                            | Api\Controllers\V1\Runs\UserController@unjoin           | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/runs/{run}/subscriptions                | runs.subscriptions.index   | Api\Controllers\V1\Runs\SubscriptionController@index    | Yes       | v1         |          |            |
|      | POST      | /api/runs/{run}/subscriptions                | runs.subscriptions.store   | Api\Controllers\V1\Runs\SubscriptionController@store    | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/runs/{run}/subscriptions/{subscription} | runs.subscriptions.show    | Api\Controllers\V1\Runs\SubscriptionController@show     | Yes       | v1         |          |            |
|      | PUT|PATCH | /api/runs/{run}/subscriptions/{subscription} | runs.subscriptions.update  | Api\Controllers\V1\Runs\SubscriptionController@update   | Yes       | v1         |          |            |
|      | DELETE    | /api/runs/{run}/subscriptions/{subscription} | runs.subscriptions.destroy | Api\Controllers\V1\Runs\SubscriptionController@destroy  | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/runs/{run}/runners                      | runs.runners.index         | Api\Controllers\V1\Runs\SubscriptionController@index    | Yes       | v1         |          |            |
|      | POST      | /api/runs/{run}/runners                      | runs.runners.store         | Api\Controllers\V1\Runs\SubscriptionController@store    | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/runs/{run}/runners/{runner}             | runs.runners.show          | Api\Controllers\V1\Runs\SubscriptionController@show     | Yes       | v1         |          |            |
|      | PUT|PATCH | /api/runs/{run}/runners/{runner}             | runs.runners.update        | Api\Controllers\V1\Runs\SubscriptionController@update   | Yes       | v1         |          |            |
|      | DELETE    | /api/runs/{run}/runners/{runner}             | runs.runners.destroy       | Api\Controllers\V1\Runs\SubscriptionController@destroy  | Yes       | v1         |          |            |
+------+-----------+----------------------------------------------+----------------------------+---------------------------------------------------------+-----------+------------+----------+------------+


# App

+--------+-----------+--------------------------------------+------------------------+------------------------------------------------------------------------+------------+
| Domain | Method    | URI                                  | Name                   | Action                                                                 | Middleware |
+--------+-----------+--------------------------------------+------------------------+------------------------------------------------------------------------+------------+
|        | GET|HEAD  | /                                    | index                  | App\Http\Controllers\HomeController@welcome                            | web        |
|        | GET|HEAD  | _debugbar/assets/javascript          | debugbar.assets.js     | Barryvdh\Debugbar\Controllers\AssetController@js                       |            |
|        | GET|HEAD  | _debugbar/assets/stylesheets         | debugbar.assets.css    | Barryvdh\Debugbar\Controllers\AssetController@css                      |            |
|        | GET|HEAD  | _debugbar/clockwork/{id}             | debugbar.clockwork     | Barryvdh\Debugbar\Controllers\OpenHandlerController@clockwork          |            |
|        | GET|HEAD  | _debugbar/open                       | debugbar.openhandler   | Barryvdh\Debugbar\Controllers\OpenHandlerController@handle             |            |
|        | POST      | broadcasting/auth                    |                        | Illuminate\Broadcasting\BroadcastController@authenticate               | web        |
|        | GET|HEAD  | cars                                 | cars.index             | App\Http\Controllers\CarController@index                               | web        |
|        | POST      | cars                                 | cars.store             | App\Http\Controllers\CarController@store                               | web,auth   |
|        | GET|HEAD  | cars/create                          | cars.create            | App\Http\Controllers\CarController@create                              | web,auth   |
|        | DELETE    | cars/{car}                           | cars.destroy           | App\Http\Controllers\CarController@destroy                             | web        |
|        | GET|HEAD  | cars/{car}                           | cars.show              | App\Http\Controllers\CarController@show                                | web        |
|        | PUT|PATCH | cars/{car}                           | cars.update            | App\Http\Controllers\CarController@update                              | web,auth   |
|        | POST      | cars/{car}/comment                   | cars.comments.store    | App\Http\Controllers\CarController@addComment                          | web        |
|        | GET|HEAD  | cars/{car}/edit                      | cars.edit              | App\Http\Controllers\CarController@edit                                | web,auth   |
|        | GET|HEAD  | groups                               | groups.index           | App\Http\Controllers\GroupController@index                             | web        |
|        | POST      | groups                               | groups.store           | App\Http\Controllers\GroupController@store                             | web        |
|        | GET|HEAD  | groups/create                        | groups.create          | App\Http\Controllers\GroupController@create                            | web        |
|        | GET|HEAD  | groups/{group}                       | groups.show            | App\Http\Controllers\GroupController@show                              | web        |
|        | PUT|PATCH | groups/{group}                       | groups.update          | App\Http\Controllers\GroupController@update                            | web        |
|        | DELETE    | groups/{group}                       | groups.destroy         | App\Http\Controllers\GroupController@destroy                           | web        |
|        | GET|HEAD  | groups/{group}/edit                  | groups.edit            | App\Http\Controllers\GroupController@edit                              | web        |
|        | GET|HEAD  | home                                 | home                   | App\Http\Controllers\HomeController@index                              | web,auth   |
|        | POST      | login                                |                        | App\Http\Controllers\Auth\LoginController@login                        | web,guest  |
|        | GET|HEAD  | login                                | login                  | App\Http\Controllers\Auth\LoginController@showLoginForm                | web,guest  |
|        | POST      | logout                               | logout                 | App\Http\Controllers\Auth\LoginController@logout                       | web        |
|        | POST      | password/email                       | password.email         | App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail  | web,guest  |
|        | POST      | password/reset                       |                        | App\Http\Controllers\Auth\ResetPasswordController@reset                | web,guest  |
|        | GET|HEAD  | password/reset                       | password.request       | App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm | web,guest  |
|        | GET|HEAD  | password/reset/{token}               | password.reset         | App\Http\Controllers\Auth\ResetPasswordController@showResetForm        | web,guest  |
|        | POST      | register                             |                        | App\Http\Controllers\Auth\RegisterController@register                  | web,auth   |
|        | GET|HEAD  | register                             | register               | App\Http\Controllers\Auth\RegisterController@showRegistrationForm      | web,auth   |
|        | POST      | runs                                 | runs.store             | App\Http\Controllers\RunController@store                               | web        |
|        | GET|HEAD  | runs                                 | runs.index             | App\Http\Controllers\RunController@index                               | web        |
|        | GET|HEAD  | runs/create                          | runs.create            | App\Http\Controllers\RunController@create                              | web        |
|        | DELETE    | runs/{run}                           | runs.destroy           | App\Http\Controllers\RunController@destroy                             | web        |
|        | PUT|PATCH | runs/{run}                           | runs.update            | App\Http\Controllers\RunController@update                              | web        |
|        | GET|HEAD  | runs/{run}                           | runs.show              | App\Http\Controllers\RunController@show                                | web        |
|        | POST      | runs/{run}/car_types                 | runs.car_types.store   | App\Http\Controllers\Run\CarTypeController@store                       | web        |
|        | GET|HEAD  | runs/{run}/car_types                 | runs.car_types.index   | App\Http\Controllers\Run\CarTypeController@index                       | web        |
|        | GET|HEAD  | runs/{run}/car_types/{car_type}      | runs.car_types.show    | App\Http\Controllers\Run\CarTypeController@show                        | web        |
|        | DELETE    | runs/{run}/car_types/{car_type}      | runs.car_types.destroy | App\Http\Controllers\Run\CarTypeController@destroy                     | web        |
|        | PUT|PATCH | runs/{run}/car_types/{car_type}      | runs.car_types.update  | App\Http\Controllers\Run\CarTypeController@update                      | web        |
|        | GET|HEAD  | runs/{run}/car_types/{car_type}/edit | runs.car_types.edit    | App\Http\Controllers\Run\CarTypeController@edit                        | web        |
|        | GET|HEAD  | runs/{run}/cars                      | runs.cars.index        | App\Http\Controllers\Run\CarController@index                           | web        |
|        | POST      | runs/{run}/cars                      | runs.cars.store        | App\Http\Controllers\Run\CarController@store                           | web        |
|        | DELETE    | runs/{run}/cars/{car}                | runs.cars.destroy      | App\Http\Controllers\Run\CarController@destroy                         | web        |
|        | PUT|PATCH | runs/{run}/cars/{car}                | runs.cars.update       | App\Http\Controllers\Run\CarController@update                          | web        |
|        | GET|HEAD  | runs/{run}/cars/{car}                | runs.cars.show         | App\Http\Controllers\Run\CarController@show                            | web        |
|        | GET|HEAD  | runs/{run}/cars/{car}/edit           | runs.cars.edit         | App\Http\Controllers\Run\CarController@edit                            | web        |
|        | GET|HEAD  | runs/{run}/edit                      | runs.edit              | App\Http\Controllers\RunController@edit                                | web        |
|        | GET|HEAD  | runs/{run}/runners                   | runs.runners.index     | App\Http\Controllers\Run\RunnerController@index                        | web        |
|        | POST      | runs/{run}/runners                   | runs.runners.store     | App\Http\Controllers\Run\RunnerController@store                        | web        |
|        | GET|HEAD  | runs/{run}/runners/{runner}          | runs.runners.show      | App\Http\Controllers\Run\RunnerController@show                         | web        |
|        | PUT|PATCH | runs/{run}/runners/{runner}          | runs.runners.update    | App\Http\Controllers\Run\RunnerController@update                       | web        |
|        | DELETE    | runs/{run}/runners/{runner}          | runs.runners.destroy   | App\Http\Controllers\Run\RunnerController@destroy                      | web        |
|        | GET|HEAD  | runs/{run}/runners/{runner}/edit     | runs.runners.edit      | App\Http\Controllers\Run\RunnerController@edit                         | web        |
|        | GET|HEAD  | schedule                             | schedule.index         | App\Http\Controllers\ScheduleController@index                          | web        |
|        | POST      | schedule                             | schedule.store         | App\Http\Controllers\ScheduleController@store                          | web        |
|        | GET|HEAD  | schedule/create                      | schedule.create        | App\Http\Controllers\ScheduleController@create                         | web        |
|        | DELETE    | schedule/{schedule}                  | schedule.destroy       | App\Http\Controllers\ScheduleController@destroy                        | web        |
|        | PUT|PATCH | schedule/{schedule}                  | schedule.update        | App\Http\Controllers\ScheduleController@update                         | web        |
|        | GET|HEAD  | schedule/{schedule}                  | schedule.show          | App\Http\Controllers\ScheduleController@show                           | web        |
|        | GET|HEAD  | schedule/{schedule}/edit             | schedule.edit          | App\Http\Controllers\ScheduleController@edit                           | web        |
|        | POST      | upload/image                         | image.upload           | App\Http\Controllers\ImageController@upload                            | web        |
|        | GET|HEAD  | users                                | users.index            | App\Http\Controllers\UserController@index                              | web        |
|        | POST      | users                                | users.store            | App\Http\Controllers\UserController@store                              | web        |
|        | GET|HEAD  | users/create                         | users.create           | App\Http\Controllers\UserController@create                             | web,auth   |
|        | GET|HEAD  | users/{user}                         | users.show             | App\Http\Controllers\UserController@show                               | web        |
|        | PUT|PATCH | users/{user}                         | users.update           | App\Http\Controllers\UserController@update                             | web,auth   |
|        | DELETE    | users/{user}                         | users.destroy          | App\Http\Controllers\UserController@destroy                            | web,auth   |
|        | GET|HEAD  | users/{user}/edit                    | users.edit             | App\Http\Controllers\UserController@edit                               | web        |
+--------+-----------+--------------------------------------+------------------------+------------------------------------------------------------------------+------------+
