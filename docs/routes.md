# App

+--------+-----------+-------------------------------+-----------------------+------------------------------------------------------------------------+------------+
| Domain | Method    | URI                           | Name                  | Action                                                                 | Middleware |
+--------+-----------+-------------------------------+-----------------------+------------------------------------------------------------------------+------------+
|        | GET|HEAD  | /                             | index                 | App\Http\Controllers\HomeController@welcome                            | web        |
|        | POST      | broadcasting/auth             |                       | Illuminate\Broadcasting\BroadcastController@authenticate               | web        |
|        | POST      | cars                          | cars.store            | App\Http\Controllers\CarController@store                               | web,auth   |
|        | GET|HEAD  | cars                          | cars.index            | App\Http\Controllers\CarController@index                               | web        |
|        | GET|HEAD  | cars/create                   | cars.create           | App\Http\Controllers\CarController@create                              | web,auth   |
|        | DELETE    | cars/{car}                    | cars.destroy          | App\Http\Controllers\CarController@destroy                             | web        |
|        | GET|HEAD  | cars/{car}                    | cars.show             | App\Http\Controllers\CarController@show                                | web        |
|        | PUT|PATCH | cars/{car}                    | cars.update           | App\Http\Controllers\CarController@update                              | web,auth   |
|        | POST      | cars/{car}/comments           | cars.comments.store   | App\Http\Controllers\CarController@addComment                          | web        |
|        | DELETE    | cars/{car}/comments/{comment} | cars.comments.destroy | App\Http\Controllers\CarController@removeComment                       | web        |
|        | GET|HEAD  | cars/{car}/edit               | cars.edit             | App\Http\Controllers\CarController@edit                                | web,auth   |
|        | GET|HEAD  | groups                        | groups.index          | App\Http\Controllers\GroupController@index                             | web,auth   |
|        | GET|HEAD  | home                          | home                  | App\Http\Controllers\HomeController@index                              | web,auth   |
|        | GET|HEAD  | kiela                         | kiela.index           | App\Http\Controllers\KielaController@index                             | web,auth   |
|        | POST      | login                         |                       | App\Http\Controllers\Auth\LoginController@login                        | web,guest  |
|        | GET|HEAD  | login                         | login                 | App\Http\Controllers\Auth\LoginController@showLoginForm                | web,guest  |
|        | POST      | logout                        | logout                | App\Http\Controllers\Auth\LoginController@logout                       | web        |
|        | POST      | password/email                | password.email        | App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail  | web,guest  |
|        | POST      | password/reset                |                       | App\Http\Controllers\Auth\ResetPasswordController@reset                | web,guest  |
|        | GET|HEAD  | password/reset                | password.request      | App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm | web,guest  |
|        | GET|HEAD  | password/reset/{token}        | password.reset        | App\Http\Controllers\Auth\ResetPasswordController@showResetForm        | web,guest  |
|        | POST      | register                      |                       | App\Http\Controllers\Auth\RegisterController@register                  | web,auth   |
|        | GET|HEAD  | register                      | register              | App\Http\Controllers\Auth\RegisterController@showRegistrationForm      | web,auth   |
|        | POST      | runs                          | runs.store            | App\Http\Controllers\RunController@store                               | web,auth   |
|        | GET|HEAD  | runs                          | runs.index            | App\Http\Controllers\RunController@index                               | web,auth   |
|        | GET|HEAD  | runs/create                   | runs.create           | App\Http\Controllers\RunController@create                              | web,auth   |
|        | GET|HEAD  | runs/display                  | runs.display          | App\Http\Controllers\RunController@display                             | web        |
|        | GET|HEAD  | runs/pdf                      | runs.pdf              | App\Http\Controllers\RunController@pdf                                 | web,auth   |
|        | GET|HEAD  | runs/{run}                    | runs.show             | App\Http\Controllers\RunController@show                                | web,auth   |
|        | PUT|PATCH | runs/{run}                    | runs.update           | App\Http\Controllers\RunController@update                              | web,auth   |
|        | DELETE    | runs/{run}                    | runs.destroy          | App\Http\Controllers\RunController@destroy                             | web,auth   |
|        | POST      | runs/{run}/comments           | runs.comments.store   | App\Http\Controllers\RunController@addComment                          | web,auth   |
|        | GET|HEAD  | runs/{run}/edit               | runs.edit             | App\Http\Controllers\RunController@edit                                | web,auth   |
|        | POST      | runs/{run}/publish            | runs.publish          | App\Http\Controllers\RunController@publish                             | web,auth   |
|        | POST      | runs/{run}/start              | runs.start            | App\Http\Controllers\RunController@start                               | web,auth   |
|        | POST      | runs/{run}/stop               | runs.stop             | App\Http\Controllers\RunController@stop                                | web,auth   |
|        | GET|HEAD  | schedule                      | schedule.index        | App\Http\Controllers\ScheduleController@index                          | web        |
|        | GET|HEAD  | users                         | users.index           | App\Http\Controllers\UserController@index                              | web        |
|        | POST      | users                         | users.store           | App\Http\Controllers\UserController@store                              | web        |
|        | GET|HEAD  | users/create                  | users.create          | App\Http\Controllers\UserController@create                             | web,auth   |
|        | PUT|PATCH | users/{user}                  | users.update          | App\Http\Controllers\UserController@update                             | web,auth   |
|        | GET|HEAD  | users/{user}                  | users.show            | App\Http\Controllers\UserController@show                               | web        |
|        | DELETE    | users/{user}                  | users.destroy         | App\Http\Controllers\UserController@destroy                            | web,auth   |
|        | GET|HEAD  | users/{user}/edit             | users.edit            | App\Http\Controllers\UserController@edit                               | web        |
|        | POST      | users/{user}/license          | image.license         | App\Http\Controllers\UserController@storeLicenseImage                  | web,auth   |
|        | GET|HEAD  | users/{user}/license          |                       | App\Http\Controllers\UserController@redirectToUser                     | web        |
|        | POST      | users/{user}/profile          | image.profile         | App\Http\Controllers\UserController@storeProfileImage                  | web,auth   |
|        | GET|HEAD  | users/{user}/profile          |                       | App\Http\Controllers\UserController@redirectToUser                     | web        |
|        | POST      | users/{user}/reset_password   | users.reset           | App\Http\Controllers\UserController@resetPassword                      | web        |
+--------+-----------+-------------------------------+-----------------------+------------------------------------------------------------------------+------------+


# Api

+------+-----------+----------------------------------------------------+----------------------------+---------------------------------------------------------+-----------+------------+----------+------------+
| Host | Method    | URI                                                | Name                       | Action                                                  | Protected | Version(s) | Scope(s) | Rate Limit |
+------+-----------+----------------------------------------------------+----------------------------+---------------------------------------------------------+-----------+------------+----------+------------+
|      | GET|HEAD  | /api                                               |                            | Api\Controllers\V1\HomeController@home                  | No        | v1         |          |            |
|      | GET|HEAD  | /api/ping                                          |                            | Api\Controllers\V1\HomeController@ping                  | No        | v1         |          |            |
|      | GET|HEAD  | /api/spec.yaml                                     |                            | Api\Controllers\V1\HomeController@spec                  | No        | v1         |          |            |
|      | GET|HEAD  | /api/users/search                                  | users.search               | Api\Controllers\V1\UserController@search                | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/me                                            | users.me                   | Api\Controllers\V1\AuthenticatedUserController@me       | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/users/me                                      |                            | Api\Controllers\V1\AuthenticatedUserController@me       | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/me/runs                                       |                            | Api\Controllers\V1\AuthenticatedUserController@runs     | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/me/schedule                                   |                            | Api\Controllers\V1\AuthenticatedUserController@schedule | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/users/{user}/image                            | user.image                 | Api\Controllers\V1\UserController@image                 | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/users/{user}/runs                             |                            | Api\Controllers\V1\UserController@run                   | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/users/{user}/group                            |                            | Api\Controllers\V1\UserController@group                 | Yes       | v1         |          |            |
|      | PUT|PATCH | /api/users/{user}/group/{group}                    |                            | Api\Controllers\V1\UserController@updateGroup           | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/users                                         | users.index                | Api\Controllers\V1\UserController@index                 | Yes       | v1         |          |            |
|      | POST      | /api/users                                         | users.store                | Api\Controllers\V1\UserController@store                 | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/users/{user}                                  | users.show                 | Api\Controllers\V1\UserController@show                  | Yes       | v1         |          |            |
|      | PUT|PATCH | /api/users/{user}                                  | users.update               | Api\Controllers\V1\UserController@update                | Yes       | v1         |          |            |
|      | DELETE    | /api/users/{user}                                  | users.destroy              | Api\Controllers\V1\UserController@destroy               | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/groups/{group}/schedules                      | groups.schedules.index     | Api\Controllers\V1\GroupScheduleController@index        | Yes       | v1         |          |            |
|      | POST      | /api/groups/{group}/schedules                      | groups.schedules.store     | Api\Controllers\V1\GroupScheduleController@store        | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/groups/{group}/schedules/{schedule}           | groups.schedules.show      | Api\Controllers\V1\GroupScheduleController@show         | Yes       | v1         |          |            |
|      | PUT|PATCH | /api/groups/{group}/schedules/{schedule}           | groups.schedules.update    | Api\Controllers\V1\GroupScheduleController@update       | Yes       | v1         |          |            |
|      | DELETE    | /api/groups/{group}/schedules/{schedule}           | groups.schedules.destroy   | Api\Controllers\V1\GroupScheduleController@destroy      | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/schedules                                     | schedules.index            | Api\Controllers\V1\ScheduleController@index             | Yes       | v1         |          |            |
|      | POST      | /api/schedules                                     | schedules.store            | Api\Controllers\V1\ScheduleController@store             | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/schedules/{schedule}                          | schedules.show             | Api\Controllers\V1\ScheduleController@show              | Yes       | v1         |          |            |
|      | PUT|PATCH | /api/schedules/{schedule}                          | schedules.update           | Api\Controllers\V1\ScheduleController@update            | Yes       | v1         |          |            |
|      | DELETE    | /api/schedules/{schedule}                          | schedules.destroy          | Api\Controllers\V1\ScheduleController@destroy           | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/groups                                        | groups.index               | Api\Controllers\V1\Groups\GroupController@index         | Yes       | v1         |          |            |
|      | POST      | /api/groups                                        | groups.store               | Api\Controllers\V1\Groups\GroupController@store         | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/groups/{group}                                | groups.show                | Api\Controllers\V1\Groups\GroupController@show          | Yes       | v1         |          |            |
|      | PUT|PATCH | /api/groups/{group}                                | groups.update              | Api\Controllers\V1\Groups\GroupController@update        | Yes       | v1         |          |            |
|      | DELETE    | /api/groups/{group}                                | groups.destroy             | Api\Controllers\V1\Groups\GroupController@destroy       | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/groups/{group}/users                          | groups.users.index         | Api\Controllers\V1\Groups\UserController@index          | Yes       | v1         |          |            |
|      | POST      | /api/groups/{group}/users                          | groups.users.store         | Api\Controllers\V1\Groups\UserController@store          | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/groups/{group}/users/{user}                   | groups.users.show          | Api\Controllers\V1\Groups\UserController@show           | Yes       | v1         |          |            |
|      | DELETE    | /api/groups/{group}/users/{user}                   | groups.users.destroy       | Api\Controllers\V1\Groups\UserController@destroy        | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/settings                                      | settings.index             | Api\Controllers\V1\SettingController@index              | Yes       | v1         |          |            |
|      | POST      | /api/settings                                      | settings.store             | Api\Controllers\V1\SettingController@store              | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/settings/{setting}                            | settings.show              | Api\Controllers\V1\SettingController@show               | Yes       | v1         |          |            |
|      | PUT|PATCH | /api/settings/{setting}                            | settings.update            | Api\Controllers\V1\SettingController@update             | Yes       | v1         |          |            |
|      | DELETE    | /api/settings/{setting}                            | settings.destroy           | Api\Controllers\V1\SettingController@destroy            | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/cars/search                                   | cars.search                | Api\Controllers\V1\Cars\CarController@search            | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/vehicles/search                               | vehicles.search            | Api\Controllers\V1\Cars\CarController@search            | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/cars/{car}/type                               | cars.type                  | Api\Controllers\V1\Cars\CarController@type              | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/vehicles/{vehicle}/type                       | cars.type                  | Api\Controllers\V1\Cars\CarController@type              | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/cars/{car}/comments                           | cars.comments.index        | Api\Controllers\V1\Cars\CommentController@index         | Yes       | v1         |          |            |
|      | POST      | /api/cars/{car}/comments                           | cars.comments.store        | Api\Controllers\V1\Cars\CommentController@store         | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/cars/{car}/comments/{comment}                 | cars.comments.show         | Api\Controllers\V1\Cars\CommentController@show          | Yes       | v1         |          |            |
|      | DELETE    | /api/cars/{car}/comments/{comment}                 | cars.comments.destroy      | Api\Controllers\V1\Cars\CommentController@destroy       | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/cars                                          | cars.index                 | Api\Controllers\V1\Cars\CarController@index             | Yes       | v1         |          |            |
|      | POST      | /api/cars                                          | cars.store                 | Api\Controllers\V1\Cars\CarController@store             | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/cars/{car}                                    | cars.show                  | Api\Controllers\V1\Cars\CarController@show              | Yes       | v1         |          |            |
|      | PUT|PATCH | /api/cars/{car}                                    | cars.update                | Api\Controllers\V1\Cars\CarController@update            | Yes       | v1         |          |            |
|      | DELETE    | /api/cars/{car}                                    | cars.destroy               | Api\Controllers\V1\Cars\CarController@destroy           | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/vehicles                                      | vehicles.index             | Api\Controllers\V1\Cars\CarController@index             | Yes       | v1         |          |            |
|      | POST      | /api/vehicles                                      | vehicles.store             | Api\Controllers\V1\Cars\CarController@store             | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/vehicles/{vehicle}                            | vehicles.show              | Api\Controllers\V1\Cars\CarController@show              | Yes       | v1         |          |            |
|      | PUT|PATCH | /api/vehicles/{vehicle}                            | vehicles.update            | Api\Controllers\V1\Cars\CarController@update            | Yes       | v1         |          |            |
|      | DELETE    | /api/vehicles/{vehicle}                            | vehicles.destroy           | Api\Controllers\V1\Cars\CarController@destroy           | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/car_types/search                              | car_types.search           | Api\Controllers\V1\CarTypeController@search             | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/car_types/{car_type}/cars                     | car_types.cars             | Api\Controllers\V1\CarTypeController@carList            | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/car_types                                     | car_types.index            | Api\Controllers\V1\CarTypeController@index              | Yes       | v1         |          |            |
|      | POST      | /api/car_types                                     | car_types.store            | Api\Controllers\V1\CarTypeController@store              | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/car_types/{car_type}                          | car_types.show             | Api\Controllers\V1\CarTypeController@show               | Yes       | v1         |          |            |
|      | PUT|PATCH | /api/car_types/{car_type}                          | car_types.update           | Api\Controllers\V1\CarTypeController@update             | Yes       | v1         |          |            |
|      | DELETE    | /api/car_types/{car_type}                          | car_types.destroy          | Api\Controllers\V1\CarTypeController@destroy            | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/waypoints/search                              | waypoints.search           | Api\Controllers\V1\WaypointController@search            | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/waypoints                                     | waypoints.index            | Api\Controllers\V1\WaypointController@index             | Yes       | v1         |          |            |
|      | POST      | /api/waypoints                                     | waypoints.store            | Api\Controllers\V1\WaypointController@store             | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/waypoints/{waypoint}                          | waypoints.show             | Api\Controllers\V1\WaypointController@show              | Yes       | v1         |          |            |
|      | DELETE    | /api/waypoints/{waypoint}                          | waypoints.destroy          | Api\Controllers\V1\WaypointController@destroy           | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/search/{model}                                |                            | Api\Controllers\V1\SearchController@fullText            | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/search                                        |                            | Api\Controllers\V1\SearchController@globalSearch        | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/runners                                       | runners.index              | Api\Controllers\V1\SubscriptionController@index         | Yes       | v1         |          |            |
|      | POST      | /api/runners                                       | runners.store              | Api\Controllers\V1\SubscriptionController@store         | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/runners/{runner}                              | runners.show               | Api\Controllers\V1\SubscriptionController@show          | Yes       | v1         |          |            |
|      | PUT|PATCH | /api/runners/{runner}                              | runners.update             | Api\Controllers\V1\SubscriptionController@update        | Yes       | v1         |          |            |
|      | DELETE    | /api/runners/{runner}                              | runners.destroy            | Api\Controllers\V1\SubscriptionController@destroy       | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/status                                        |                            | Api\Controllers\V1\StatusController@index               | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/status/vehicle                                |                            | Api\Controllers\V1\StatusController@vehicle             | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/status/{model}                                |                            | Api\Controllers\V1\StatusController@model               | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/runs/search                                   | runs.search                | Api\Controllers\V1\Runs\RunController@search            | Yes       | v1         |          |            |
|      | POST      | /api/runs/{run}/publish                            | runs.publish               | Api\Controllers\V1\Runs\RunController@publish           | Yes       | v1         |          |            |
|      | POST      | /api/runs/{run}/start                              | runs.start                 | Api\Controllers\V1\Runs\RunController@start             | Yes       | v1         |          |            |
|      | POST      | /api/runs/{run}/stop                               | runs.stop                  | Api\Controllers\V1\Runs\RunController@stop              | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/runs                                          | runs.index                 | Api\Controllers\V1\Runs\RunController@index             | Yes       | v1         |          |            |
|      | POST      | /api/runs                                          | runs.store                 | Api\Controllers\V1\Runs\RunController@store             | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/runs/{run}                                    | runs.show                  | Api\Controllers\V1\Runs\RunController@show              | Yes       | v1         |          |            |
|      | PUT|PATCH | /api/runs/{run}                                    | runs.update                | Api\Controllers\V1\Runs\RunController@update            | Yes       | v1         |          |            |
|      | DELETE    | /api/runs/{run}                                    | runs.destroy               | Api\Controllers\V1\Runs\RunController@destroy           | Yes       | v1         |          |            |
|      | DELETE    | /api/runs/{run}/waypoints                          | runs.waypoints.destroy_all | Api\Controllers\V1\Runs\WaypointController@deleteAll    | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/runs/{run}/waypoints                          | runs.waypoints.index       | Api\Controllers\V1\Runs\WaypointController@index        | Yes       | v1         |          |            |
|      | POST      | /api/runs/{run}/waypoints                          | runs.waypoints.store       | Api\Controllers\V1\Runs\WaypointController@store        | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/runs/{run}/waypoints/{waypoint}               | runs.waypoints.show        | Api\Controllers\V1\Runs\WaypointController@show         | Yes       | v1         |          |            |
|      | PUT|PATCH | /api/runs/{run}/waypoints/{waypoint}               | runs.waypoints.update      | Api\Controllers\V1\Runs\WaypointController@update       | Yes       | v1         |          |            |
|      | DELETE    | /api/runs/{run}/waypoints/{waypoint}               | runs.waypoints.destroy     | Api\Controllers\V1\Runs\WaypointController@destroy      | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/runs/{run}/comments                           | runs.comments.index        | Api\Controllers\V1\Runs\CommentController@index         | Yes       | v1         |          |            |
|      | POST      | /api/runs/{run}/comments                           | runs.comments.store        | Api\Controllers\V1\Runs\CommentController@store         | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/runs/{run}/comments/{comment}                 | runs.comments.show         | Api\Controllers\V1\Runs\CommentController@show          | Yes       | v1         |          |            |
|      | PUT|PATCH | /api/runs/{run}/comments/{comment}                 | runs.comments.update       | Api\Controllers\V1\Runs\CommentController@update        | Yes       | v1         |          |            |
|      | DELETE    | /api/runs/{run}/comments/{comment}                 | runs.comments.destroy      | Api\Controllers\V1\Runs\CommentController@destroy       | Yes       | v1         |          |            |
|      | POST      | /api/runs/{run}/subscriptions/{subscription}/start | runs.sub.start             | Api\Controllers\V1\Runs\SubscriptionController@start    | Yes       | v1         |          |            |
|      | POST      | /api/runs/{run}/subscriptions/{subscription}/stop  | runs.sub.stop              | Api\Controllers\V1\Runs\SubscriptionController@stop     | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/runs/{run}/subscriptions                      | runs.subscriptions.index   | Api\Controllers\V1\Runs\SubscriptionController@index    | Yes       | v1         |          |            |
|      | POST      | /api/runs/{run}/subscriptions                      | runs.subscriptions.store   | Api\Controllers\V1\Runs\SubscriptionController@store    | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/runs/{run}/subscriptions/{subscription}       | runs.subscriptions.show    | Api\Controllers\V1\Runs\SubscriptionController@show     | Yes       | v1         |          |            |
|      | PUT|PATCH | /api/runs/{run}/subscriptions/{subscription}       | runs.subscriptions.update  | Api\Controllers\V1\Runs\SubscriptionController@update   | Yes       | v1         |          |            |
|      | DELETE    | /api/runs/{run}/subscriptions/{subscription}       | runs.subscriptions.destroy | Api\Controllers\V1\Runs\SubscriptionController@destroy  | Yes       | v1         |          |            |
|      | POST      | /api/runs/{run}/runners/{runner}/start             | runs.runner.start          | Api\Controllers\V1\Runs\SubscriptionController@start    | Yes       | v1         |          |            |
|      | POST      | /api/runs/{run}/runners/{runner}/stop              | runs.runner.stop           | Api\Controllers\V1\Runs\SubscriptionController@stop     | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/runs/{run}/runners                            | runs.runners.index         | Api\Controllers\V1\Runs\SubscriptionController@index    | Yes       | v1         |          |            |
|      | POST      | /api/runs/{run}/runners                            | runs.runners.store         | Api\Controllers\V1\Runs\SubscriptionController@store    | Yes       | v1         |          |            |
|      | GET|HEAD  | /api/runs/{run}/runners/{runner}                   | runs.runners.show          | Api\Controllers\V1\Runs\SubscriptionController@show     | Yes       | v1         |          |            |
|      | PUT|PATCH | /api/runs/{run}/runners/{runner}                   | runs.runners.update        | Api\Controllers\V1\Runs\SubscriptionController@update   | Yes       | v1         |          |            |
|      | DELETE    | /api/runs/{run}/runners/{runner}                   | runs.runners.destroy       | Api\Controllers\V1\Runs\SubscriptionController@destroy  | Yes       | v1         |          |            |
+------+-----------+----------------------------------------------------+----------------------------+---------------------------------------------------------+-----------+------------+----------+------------+
