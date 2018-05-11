<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Provider
    |--------------------------------------------------------------------------
    |
    | Load your desired Push provider.
    |
    | Make sure your provider extends the push interface to make sure
    | that all the required methods has been implemented
    |
    */
    'credentials' => function () {
        return [
            'appId'   => env('NSTACK_APP_ID'),
            'restKey' => env('NSTACK_REST_KEY'),
        ];
    },
];
