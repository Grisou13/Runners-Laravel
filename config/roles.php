<?php
return [
  "admin"=>[
    "inherits_from"=>["coordinator"]
  ],
  "coordinator"=>[
    "force run end",
    "inherits_from"=>["runner"]
  ],
  "runner"=>[
    "end run"
  ],
  "anonym"=>[
    "view runs",
    "view cars",
    "view car types",
    "view waypoints",
    "view "
  ]
];