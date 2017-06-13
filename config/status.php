<?php

return [
  "user"=>[
    "active"=>"Actif",
    "taken"=>"Utilisé dans un run",
    "gone"=>"Est parti en run",
    "not_present"=>"Pas présent",
    "free"=>"Disponible"
  ],
  "car_type"=>[
    "active"=>"Actif",
    "used"=>"Utilisé",
    "free"=>"Disponible"
  ],
  "run"=>[
    //"active"=>"actif",
    "gone"=>"Démarré",
    "error"=>"Il manque des information pour démarrer le run", //not used
    "finished"=>"le run est terminé",
    "needs_filling"=>"En train d'être finalisé",
    "missing_cars"=>"Il manque des voiture pour démarrer le run",
    "ready"=>"Pret",
    "empty"=>"vide",
    "drafting"=>"En train d'être organisé"
  ],
  "run_subscription"=>[
    "ready_to_go"=>"Pret",
    "missing_user"=>"Il manque un chauffeur",
    "missing_car"=>"Il manque une voiture",
    "needs_filling"=>"Il faut encore remplir les imformations pour l'utilisateur, la voiture, ou le type de voiture",
    "gone"=>"Le run est parti",
    "error"=>"Quelque chose c'est vraiment mal passé",
    "finished"=>"Ce convoi est terminé"
  ],
  "car"=>[
    "active"=>"Actif",
    "taken"=>"Utilisé",
    "gone"=>"Parti",
    "free"=>"Disponible",
    "problem"=>"La voiture n'est pas en &eacute;tat de fonctionnement"
  ]
];
