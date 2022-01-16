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

    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->post('logout', 'AuthenticationController@logout');
        $router->get('me', 'AuthenticationController@me');
    });
});

// roles
$router->group(['prefix' => 'roles', 'middleware' => 'auth'], function () use ($router) {
    $router->post('new', 'RolesController@create');
    $router->get('show', 'RolesController@index');
    $router->get('show/{id}', 'RolesController@show');
    $router->put('update/{id}', 'RolesController@update');
    $router->delete('delete/{id}', 'RolesController@delete');
});

// roles
$router->group(['prefix' => 'users', 'middleware' => 'auth'], function () use ($router) {
    $router->post('new', 'UsersController@create');
    $router->get('show', 'UsersController@index');
    $router->get('show/{id}', 'UsersController@show');
    $router->put('update/{id}', 'UsersController@update');
    $router->delete('delete/{id}', 'UsersController@delete');
});


//api/v1
    //auth*
        //login*
        //register*
    //users*
        //new*
        //show*
        //update/:id*
        //delete/:id*
    //roles*
        //new*
        //show*
        //update/:id*
        //delete/:id*
    //products
        //new
        //show
        //update/:id
        //delete/:id
