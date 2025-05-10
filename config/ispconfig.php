<?php
return [
  'soap' => [
    'active' => env('ISPCONFIG_SOAP_ACTIVE', 'false'),

    'connection' => [
      'uri' => env('ISPCONFIG_SOAP_URI', 'https://localhost:8080/remote/'),
      'location' => env('ISPCONFIG_SOAP_LOCATION', 'https://localhost:8080/remote'),
      'username' => env('ISPCONFIG_SOAP_USERNAME', 'remote_user'),
      'password' => env('ISPCONFIG_SOAP_PASSWORD', 'secret'),
    ],
  ]
];
