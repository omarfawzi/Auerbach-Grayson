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

use Laravel\Lumen\Routing\Router;

$router->group(['prefix' => 'api'], function (Router $router) {

    $router->post('/login', 'AuthController@login');

    $router->group(['prefix'=>'reports'], function (Router $router) {
        $router->get('/', 'ReportController@index');
        $router->get('/{id}', 'ReportController@show');
    });

    $router->group(['prefix'=>'companies'], function (Router $router) {
        $router->get('/', 'CompanyController@index');
    });

    $router->group(['prefix'=>'sectors'], function (Router $router) {
        $router->get('/', 'SectorController@index');
    });
});


