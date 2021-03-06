<?php
    include __DIR__.'/src/init.php';
    include __DIR__.'/src/autoload/autoload.php';

    use Application\Container\Dependency;
    use Application\Container\DIContainer as Container;
    use Application\Container\DIContainer;
    use Application\Container\IContainer;
    use Dependencies\Event\EventArgs;
    use Dependencies\Http\Request as Request;
    use Dependencies\Http\Respone;
    use Dependencies\Router\Router as Router;
    use Dependencies\Router\Route as Route;
    use Dependencies\HttpHandler\HttpHandler as HttpHandler;
    use Dependencies\Notification\EventClient as EventClient;
    use Dependencies\Parsing\URLParser;

if (ob_get_level() == 0) ob_start();
    
    header('Access-Control-Allow-Origin: *');

    $request = Dependencies\HttpHandler\HttpHandler::Request();

    $app = new \Application\Application($request);

    $app->start();

    $router = $app->router;

    $router->Get('/c', function (Request $_request) {
        return $_request->Route()->GetUriPattern();
    });

    $router->Get('/', function(Request $request) {
        return $request->Method();
    })->name('home');

    $router->Put('/test', function (Router $router) {

        return 'put method';
    });

    $router->Domain('{test}.localhost', function (Router $router) {

        $router->Get('/', function (Request $req) {
            return $req->Host();
        });

        $router->Get('/domain', function () {

        });
    });

    $router->Domain('dev.localhost', function (Router $router) {

        // $router->AllVerbs('/[a-z]*', function (Request $_request) {
        //     return 'dev'.$_request->Method();
        // });

        $router->Get('/', function (Request $_request) {
            return 'dev'.$_request->Method();
        });
    });


    $respone = $router->Handle($request);

    $respone->send();
    
    $app->Terminate();

    


    
