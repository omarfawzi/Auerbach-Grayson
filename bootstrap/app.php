<?php

use App\Http\Middleware\Authenticate;
use App\Providers\AuthServiceProvider;
use App\Providers\EventServiceProvider;
use EloquentFilter\LumenServiceProvider;
use Flipbox\LumenGenerator\LumenGeneratorServiceProvider;
use Laravel\Lumen\Application;
use Spatie\Fractal\FractalServiceProvider;
use Spatie\QueryBuilder\QueryBuilderServiceProvider;
use SwaggerLume\ServiceProvider;

require_once __DIR__.'/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();


/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
 */

$app = new Application(
    dirname(__DIR__)
);

$app->configure('app');
$app->configure('auth');
$app->configure('api');
$app->configure('swagger-lume');
// $app->configure('broadcasting');
// $app->configure('cache');
$app->configure('database');
$app->configure('mail');
// $app->configure('filesystems');
// $app->configure('logging');
$app->configure('queue');
// $app->configure('services');
// $app->configure('view');

$app->withFacades();
$app->withEloquent();



/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);


/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
 */


$app->middleware([
    // ...
    Fruitcake\Cors\HandleCors::class,
]);

$app->routeMiddleware([
    'auth' => Authenticate::class,
]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
 */

$app->register(App\Providers\AppServiceProvider::class);
$app->register(AuthServiceProvider::class);
$app->register(EventServiceProvider::class);
$app->register(FractalServiceProvider::class);
$app->register(QueryBuilderServiceProvider::class);
$app->register(\Tymon\JWTAuth\Providers\LumenServiceProvider::class);
$app->register(LumenServiceProvider::class);
$app->register(ServiceProvider::class);
$app->register(Illuminate\Mail\MailServiceProvider::class);
$app->register(Fruitcake\Cors\CorsServiceProvider::class);

$app->alias('mailer', Illuminate\Mail\Mailer::class);
$app->alias('mailer', Illuminate\Contracts\Mail\Mailer::class);
$app->alias('mailer', Illuminate\Contracts\Mail\MailQueue::class);

if ($app->environment() == 'local') {
    $app->register(LumenGeneratorServiceProvider::class);
}

config(['eloquentfilter.namespace' => "App\\Models\\Filters\\"]);

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
 */

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__.'/../routes/api.php';
});

return $app;
