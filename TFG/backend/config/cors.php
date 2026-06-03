<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'https://tfg-zona-gamer-o9uj.vercel.app'
    ],

    'allowed_headers' => ['*'],

    'supports_credentials' => true,

];