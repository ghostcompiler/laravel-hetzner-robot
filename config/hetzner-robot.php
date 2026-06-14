<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Hetzner Robot API Web Service Credentials
    |--------------------------------------------------------------------------
    |
    | Your Hetzner Robot Web Service username and password. You can create
    | a web service user in the Robot Console settings.
    |
    */
    'username' => env('HETZNER_ROBOT_USERNAME'),
    'password' => env('HETZNER_ROBOT_PASSWORD'),

    /*
    |--------------------------------------------------------------------------
    | Base API URL
    |--------------------------------------------------------------------------
    |
    | The base URL of the Hetzner Robot Web Service API.
    |
    */
    'base_url' => env('HETZNER_ROBOT_BASE_URL', 'https://robot-ws.your-server.de'),

    /*
    |--------------------------------------------------------------------------
    | Request Timeout
    |--------------------------------------------------------------------------
    |
    | The default request timeout in seconds.
    |
    */
    'timeout' => (int) env('HETZNER_ROBOT_TIMEOUT', 30),

    /*
    |--------------------------------------------------------------------------
    | Retry Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for rate limit retries and server error retries.
    |
    */
    'retries' => (int) env('HETZNER_ROBOT_RETRIES', 3),
    'retry_backoff' => (int) env('HETZNER_ROBOT_RETRY_BACKOFF', 100), // ms multiplier

    /*
    |--------------------------------------------------------------------------
    | Logging
    |--------------------------------------------------------------------------
    |
    | When enabled, requests and responses will be logged using Laravel's
    | Log service.
    |
    */
    'logging' => [
        'enabled' => (bool) env('HETZNER_ROBOT_LOGGING_ENABLED', false),
        'channel' => env('HETZNER_ROBOT_LOGGING_CHANNEL'),
    ],
];
