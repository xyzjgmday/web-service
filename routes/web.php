<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('hello-lumen/{name}', function ($name) {
    return "<h1>Lumen<h1/><p>Halo <b>" . $name ."</b>, terimakasih sudah menggunakan Lumen</p>";
});

$router->get('/scores', [
    'middleware' => 'login',
    function () {
        return "<h1>Selamat</h1><p>Hi Nilai anda 100</p>";
    }
]);

$router->post('/login', 'AuthController@login');
$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('/users', 'UsersController@index');
    $router->get('/users/{id}', 'UsersController@show');
});