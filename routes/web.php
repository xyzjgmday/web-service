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

// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });

$router->get('/', function () {
    return response()->json(['service_name' => 'PHP Service App', 'status' => 'Running']);
});

$router->get('/hello-lumen/{name}', function ($name) {
    return "<h1>Lumen</h1><p>Hi " . $name . ", Thans for using Lumen</p>";
});

$router->get('/scores', [
    'middleware' => 'login',
    function () {
        return "<h1>Selamat</h1><p>Hi Nilai anda 100</p>";
    }
]);

// $router->post('/login', 'AuthController@login');
$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('/users', 'UsersController@index');
    $router->get('/users/{id}', 'UsersController@show');
    $router->get('role', 'RoleController@index');

    //master Posts
    $router->get('posts', 'PostsController@index');
    $router->post('posts', 'PostsController@store');
    $router->get('post/{id}', 'PostsController@show');
    $router->put('post/{id}', 'PostsController@update');
    $router->delete('post/{id}', 'PostsController@destroy');
});
$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('/register', 'AuthController@register');
    $router->post('/login', 'AuthController@login');
});

$router->group(['prefix' => 'public', 'namespace' => 'Publish',], function () use ($router) {
    $router->get('posts', 'PostsController@index');
    $router->get('post/{id}', 'PostsController@show');
});

    $router->post('comments', 'CommentsController@store');
    $router->get('/posts/{id}/comments', 'CommentsController@show');