<?php
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

    $router->post('/login', 'AuthController@login');

    $router->group(['prefix'=>'reports'], function ($router) {
        $router->get('/', 'ReportController@index');
        $router->get('/{id}', 'ReportController@show');
    });

    $router->group(['prefix'=>'companies'], function ($router) {
        $router->get('/', 'CompanyController@index');
    });
});


