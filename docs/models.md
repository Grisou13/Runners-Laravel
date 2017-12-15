# Models

Models are not registered in the `app/` folder.
This is for very simple reason. Models aren't exclusive to the app, nor the api.
This is why there is a `lib/` folder.

The only special Model here is `RunSubscription`

_The status of any model is adapted in Observers and not in controllers._
_Please refer to [diagrams.md](diagrams.md)_

## User

The user model is used as generic as possible. It is used to authenticate on the app and api.
The distinction between a coordinator and a driver is done with roles and permissions ([read more about roles, and permissions](roles.md))

The user model has a special `accesstoken` field. This is used to directly authenticate through the api.

## RunSubscription

This model holds the information of which convoys are sent for which run.
It is stored in `run_drivers` table.

It allows you to associate a car, or car_type with a driver.

If you want to add a driver to a run you would create a RunSubscription
```
use Lib\Models\RunSubscription
use Lib\Models\Run

$run = Run::find(1);
$sub = new RunSubscription();
$sub->run()->associate($run);

// add a user

$sub->user()->asssociate(User::find(1));

//add a car type

$sub->car_type()->associate(CarType::find(1));

//add a car

$sub->car()->associate(Car::find(1));


$sub->save();
```

# Observers

## RunObserver

This observer will change the runs status. Nothing is handeld in controllers!.

| Event                       | Description                                                           |
|-----------------------------|-----------------------------------------------------------------------|
| RunSubscriptionSavedEvent   | This event will trigger the run to change it's status.                |
| RunSubscriptionDeletedEvent | This event will trigger the run to change it's status.                |
| RunSavingEvent              | This event will trigger the run to change it's status.                |
| RunDeletingEvent            | Set's the ended_at field of the run and makes it's status to finished |
| RunCreatingEvent            | Set's the runs status to drafting                                     |

## RunSubObserver

| Event                       | Description                                                           |
|-----------------------------|-----------------------------------------------------------------------|
| RunSubscriptionSavedEvent   | This event will trigger the run to change it's status.                |
| RunSubscriptionDeletedEvent | Deletes all run subscriptions                                         |
