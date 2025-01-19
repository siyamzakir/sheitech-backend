<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],  // Allow all methods (GET, POST, PUT, DELETE, etc.)

    'allowed_origins' => ['*'],  // Replace wildcard with specific origin

    'allowed_origins_patterns' => [],  // Optional, use for dynamic origins if needed

    'allowed_headers' => ['*'],  // Allow all headers

    'exposed_headers' => [],  // List headers you want exposed to the frontend, if needed

    'max_age' => 0,

    'supports_credentials' => true,  // Enable if you're using cookies or authentication tokens
];
