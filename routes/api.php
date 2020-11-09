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

use App\Http\Middleware\Authenticate;
use Laravel\Lumen\Routing\Router;

$router->group(['prefix' => 'api'], function (Router $router) {

    $router->post('/login', 'AuthController@login');
    $router->post('/forget', 'AuthController@forgetPassword');

    $router->group(['middleware' => Authenticate::class],function (Router $router){

        $router->group(['prefix'=>'reports'], function (Router $router) {
        $router->get('/', 'ReportController@index');
        $router->get('/{id}', 'ReportController@show');
        $router->post('/{id}/save','SavedReportController@save');
        $router->delete('/{id}/unsave','SavedReportController@unsave');
        $router->group(['prefix'=>'/{id}/analysts'],function (Router $router){
            $router->post('/email', 'AnalystController@email');
            $router->post('/contact', 'AnalystController@contact');
           });
        });

        $router->group(['prefix'=>'companies'], function (Router $router) {
            $router->get('/', 'CompanyController@index');
            $router->get('/all', 'CompanyController@getAllCompanies');
        });

        $router->group(['prefix'=>'sectors'], function (Router $router) {
            $router->get('/', 'SectorController@index');
        });

        $router->group(['prefix'=>'recommendations'], function (Router $router) {
            $router->get('/', 'RecommendationController@index');
        });

        $router->group(['prefix'=>'regions'], function (Router $router) {
            $router->get('/', 'RegionController@index');
        });

        $router->group(['prefix'=>'subscriptions'], function (Router $router) {
            $router->get('/', 'SubscriptionController@index');
            $router->post('/', 'SubscriptionController@store');
            $router->delete('/{id}', 'SubscriptionController@destroy');
        });

        $router->group(['prefix'=>'types'], function (Router $router) {
            $router->get('/', 'TypeController@index');
        });

        $router->get('/user', 'AuthController@getLoggedUser');
        $router->get('/token', 'AuthController@refreshToken');

    });

});



$router->group(['prefix' => 'general'], function (Router $router) {

    $router->group(['prefix'=>'reports'], function (Router $router) {
        $router->get('/', 'ReportController@generalList');
    });

});


