<?php

/** @var Router $router */

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

use Laravel\Lumen\Routing\Router;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// Auth
$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('login', 'AuthenticationController@login');
    $router->post('register', 'RegistrationController@register');
});


//api/v1
    //auth
        //login
        //register
    //users
        //new
        //show
        //update/:id
        //delete/:id
    //roles
        //new
        //show
        //update/:id
        //delete/:id
    //products
        //new
        //show
        //update/:id
        //delete/:id
