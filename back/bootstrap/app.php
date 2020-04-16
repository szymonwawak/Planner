<?php


session_start();

require __DIR__ . '/../vendor/autoload.php';


$settings = require __DIR__ . '/../app/settings.php';
$app = new \Slim\App($settings);


$container = $app->getContainer();


$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);

$capsule->setAsGlobal();
$capsule->bootEloquent();


$container['db'] = function ($container) use ($capsule) {
    return $capsule;
};


$container ['HomeController'] = function ($container) {

    return new \App\Controllers\HomeController($container);
};

$container ['AuthController'] = function ($container) {

    return new \App\Controllers\Auth\AuthController($container);
};

$container ['Middleware'] = function ($container) {

    return new \App\Middleware\Middleware($container);
};


require __DIR__ . '/../app/middleware.php';
require __DIR__ . '/../app/routes.php';
