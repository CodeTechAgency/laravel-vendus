<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Working Mode
    |--------------------------------------------------------------------------
    |
    | Here you can set your working mode.
    | Allowed values: normal, tests
    |
    */
    'mode' => env('VENDUS_MODE', 'tests'),

    'api_key' => env('VENDUS_API_KEY'),

    'app_url' => env('VENDUS_APP_URL'),

];
