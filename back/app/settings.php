<?php
return [
    'settings' => [

        'displayErrorDetails' => true,

        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'consultations',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ],

        "jwt" => [
            'secret' => 'secretpass'
        ],
    ],
];