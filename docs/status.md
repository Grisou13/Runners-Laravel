# Available statuses and models

## Lib\Models\User

| status key name | displayable value               |
|-----------------|---------------------------------|
| active          | Actif                           |
| taken           | En cours de run                 |
| not_present     | L'utilisateur n'est pas présent |
| free            | Disponible                      |

## Lib\Models\Car

| status key name | displayable value                              |
|-----------------|------------------------------------------------|
| active          | Actif                                          |
| taken           | En cours de run                                |
| problem         | La voiture n'est pas en état de fonctionnement |
| free            | Disponible                                     |

## Lib\Models\Run

| status key name | displayable value                                     |
|-----------------|-------------------------------------------------------|
| active          | Actif                                                 |
| gone            | Démarré                                               |
| ready           | Le run est prêt à être lancé                          |
| needs_filling   | Il n'y a actuellement aucun convoie prévu pour le run |

## Lib\Models\RunSubscription

| status key name | displayable value                                                                             |
|-----------------|-----------------------------------------------------------------------------------------------|
| ready_to_go     | Pret                                                                                          |
| missing_user    | Il manque un chauffeur                                                                        |
| missing_car     | Il manque une voiture                                                                         |
| needs_filling   | Il faut encore remplir les imformations pour l'utilisateur, la voiture, ou le type de voiture |
| gone            | Le run est parti                                                                              |

# Status handling

All statuses are handled by Observers.
This allows the app to be flexible, and only have one single point where statuses are handled!
For more information take a look at [models.md](models.md#Observers)
