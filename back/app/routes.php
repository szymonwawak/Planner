<?php


$app->get('/home', 'HomeController:index')->setName('home');


$app->get('/auth/login','AuthController:login')->setName('auth.login');
$app->post('/auth/login','AuthController:login');

