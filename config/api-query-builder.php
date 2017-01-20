<?php

return [

    'limit' => 15,

    'orderBy' => [
        [
            'column' => 'created_at',
            'direction' => 'desc'
        ]
    ],

    'excludedParameters' => ["token","paginated"],

];
