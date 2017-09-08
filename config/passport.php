<?php

return [
    'grant_type' => 'password',
    'client_id' => env('OAUTH_CLIENT_ID','2'),
    'client_secret' => env('OAUTH_CLIENT_SECRET'),
    'scope' => env('OAUTH_SCOPE', '*'),
];
