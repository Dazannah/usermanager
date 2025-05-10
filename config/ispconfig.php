<?php
return [
  'soap' => [
    'active' => env('ISPCONFIG_ACTIVE', 'false'),

    'connection' => [
      'uri' => env('ISPCONFIG_URI', 'https://localhost:8080/remote/'),
      'location' => [env('ISPCONFIG_LOCATION', 'https://localhost:8080/remote')],
      'username' => env('ISPCONFIG_USERNAME', 'remote_user'),
      'password' => env('ISPCONFIG_PASSWORD', 'secret'),
    ],
  ]
];
