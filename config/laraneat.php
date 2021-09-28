<?php

return [
    'api' => [
        /*
        |--------------------------------------------------------------------------
        | Rate Limit (throttle)
        |--------------------------------------------------------------------------
        |
        | Attempts per minutes.
        | `attempts` the number of attempts per `expires` in minutes.
        |
        */
        'throttle' => [
            'enabled' => env('API_RATE_LIMIT_ENABLED', true),
            'attempts' => env('API_RATE_LIMIT_ATTEMPTS', '60'),
            'expires' => env('API_RATE_LIMIT_EXPIRES', '1'),
        ]
    ],

    'spa_url' => env('SPA_URL'),

    'requests' => [
        /*
        |--------------------------------------------------------------------------
        | Force Request Header to Contain header
        |--------------------------------------------------------------------------
        |
        | By default, users can send request without defining the accept header and
        | setting it to [ accept = application/json ].
        | To force the users to define that header, set this to true.
        | When set to true, a PHP exception will be thrown preventing users from access
        | When set to false, the header will contain a warning message.
        |
        */
        'force-accept-header' => false,
    ],

    'seeders' => [
        /*
        |--------------------------------------------------------------------------
        | Special seeders for laraneat:seed-deploy & laraneat:seed-test commands
        |--------------------------------------------------------------------------
        |
        */
        'deployment' => App\Ship\Seeders\SeedDeploymentData::class,
        'testing' => App\Ship\Seeders\SeedTestingData::class
    ],

    'tests' => [
        /*
        |--------------------------------------------------------------------------
        | In order to be able to create testing user in your tests using test helpers, tests needs to know
        | the name of the user model.This is working by default but if you are using another
        | user model you should update this config.
        | This user model MUST have a factory defined.
        |--------------------------------------------------------------------------
        |
        */
        'user-class' => App\Modules\User\Models\User::class,

        /*
        |--------------------------------------------------------------------------
        | In order to be able to create admin testing user in your tests using test helpers, tests needs to know
        | the name of the admin state in user factory. This is working by default but if you are using another
        | user model, or you have changed the default admin state name you should update this config.
        |--------------------------------------------------------------------------
        |
        */
        'user-admin-state' => 'admin',

        'guard' => 'sanctum'
    ]
];
