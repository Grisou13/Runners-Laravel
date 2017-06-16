# Available statuses and models

## Lib\Models\User

| status key name | displayable value               |
|-----------------|---------------------------------|
| active          | Actif                           |
| taken           | En cours de run                 |
| gone            | Est parti en run                |
| not_present     | L'utilisateur n'est pas présent |
| free            | Disponible                      |

## Lib\Models\Car

| status key name | displayable value                                      |
|-----------------|--------------------------------------------------------|
| active          | Actif                                                  |
| taken           | Utilisé                                                |
| free            | Disponible                                             |
| gone            | Parti                                                  |
| problem         | La voiture n'est pas en état de fonctionnement  |

## Lib\Models\Run

| status key name | displayable value                                     |
|-----------------|-------------------------------------------------------|
| gone            | Démarré                                               |
| error           | Il manque des information pour démarrer le run        |
| finished        | le run est terminé                                    |
| missing_cars    | Il manque des voiture pour démarrer le run            |
| empty           | vide                                                  |
| ready           | Le run est prêt à être lancé                          |
| needs_filling   | En train d'être finalisé                              |
| drafting        | En train d'être organisé                              |

## Lib\Models\RunSubscription

| status key name | displayable value                                                                             |
|-----------------|-----------------------------------------------------------------------------------------------|
| ready_to_go     | Pret                                                                                          |
| missing_user    | Il manque un chauffeur                                                                        |
| missing_car     | Il manque une voiture                                                                         |
| needs_filling   | Il faut encore remplir les imformations pour l'utilisateur, la voiture, ou le type de voiture |
| gone            | Le run est parti                                                                              |
| error           | Il y a un problèmr grave avec le convoi                                                       |
| finished        | Ce convoi est terminé                                                                         |

# Status handling

All statuses are handled and changed by Observers.
This allows the app to be flexible, and only have one single point where statuses are handled!
For more information take a look at [models.md](models.md#Observers)
