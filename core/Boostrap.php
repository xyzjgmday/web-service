<?php

require __DIR__.'/Router.php';
require __DIR__.'/../config/Routers.php';

$router = new Router;
$router->setRoutes($routes);

$url = $_SERVER['REQUEST_URI'];
require __DIR__."/../controller/".$router->getFilename($url);