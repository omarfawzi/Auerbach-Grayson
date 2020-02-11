<?php

use Illuminate\Http\Response;
use Carbon\Carbon;

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


$router->group(['prefix' => 'api'], function ($router) {

    $router->post('/auth', 'AuthController@login');

    $router->group(['middleware' => 'auth:api', 'prefix' => 'auth'], function ($router) {
        $router->get('/', 'AuthController@show');
        $router->put('/', 'AuthController@update');
        $router->delete('/', 'AuthController@destroy');
    });

    $router->group(['middleware' => 'auth:api', 'prefix' => 'users'], function ($router) {
        $router->get('/', 'UserController@index');
        $router->post('/', 'UserController@store');
        $router->get('/{id:[0-9]+}', 'UserController@show');
        $router->put('/{id:[0-9]+}', 'UserController@update');
        $router->delete('/{id:[0-9]+}', 'UserController@destroy');
    });
});


