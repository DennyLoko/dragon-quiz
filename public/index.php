<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

use DI\ContainerBuilder;
use DragonQuiz\Controller\Menu;
use DragonQuiz\Controller\Admin;
use DragonQuiz\Controller\Ranking;
use DragonQuiz\Controller\QuestionsAnswers;
use DragonQuiz\Controller\UserController;
use FastRoute\RouteCollector;
use Middlewares\FastRoute;
use DragonQuiz\Middleware\Auth;
use Middlewares\RequestHandler;
use Narrowspark\HttpEmitter\SapiEmitter;
use Relay\Relay;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;
use function DI\create;
use function DI\get;
use function FastRoute\simpleDispatcher;

if (PHP_OS != "Linux") {
    $_SERVER['REQUEST_URI'] = substr($_SERVER['REQUEST_URI'], (strlen('/dragon-quiz/public')));
}

session_start();

require_once dirname(__DIR__) . '/bootstrap.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->useAutowiring(false);
$containerBuilder->useAnnotations(false);

$containerBuilder->addDefinitions([
    Auth::class => create(Auth::class)
        ->constructor(
            get('Response'),
            get('Twig'),
            get('EntityManager')
        ),

    Ranking::class => create(Ranking::class)
        ->constructor(
            get('Response'),
            get('Twig'),
            get('EntityManager')
        ),
    Admin::class => create(Admin::class)
        ->constructor(
            get('Response'),
            get('Twig'),
            get('EntityManager')
        ),
    QuestionsAnswers::class => create(QuestionsAnswers::class)
        ->constructor(
            get('Response'),
            get('Twig'),
            get('EntityManager')
        ),
    Menu::class => create(Menu::class)
        ->constructor(
            get('Response'),
            get('Twig'),
            get('EntityManager')
        ),
    UserController::class => create(UserController::class)
        ->constructor(
            get('Response'),
            get('Twig'),
            get('EntityManager')
        ),
    'Response' => function () {
        return new Response();
    },
    'Twig' => function () {
        $loader = new FilesystemLoader(dirname(__DIR__) . '/src/view/');

        $twig = new Environment($loader, [
            'cache' => dirname(__DIR__) . '/src/view/cache/',
        ]);

        return $twig;
    },
    'EntityManager' => function () use ($entityManager) {
        return $entityManager;
    }
]);

$container = $containerBuilder->build();

$routes = simpleDispatcher(
    function (RouteCollector $r) {
        $r->get('/', Menu::class);
        $r->get('/ranking', Ranking::class);

        $r->get('/admin', [Admin::class, 'form']);
        $r->post('/admin', [Admin::class, 'save']);

        $r->get('/game', [QuestionsAnswers::class, 'index']);
        $r->post('/game', [QuestionsAnswers::class, 'updatePoints']);

        $r->get('/register', UserController::class);
        $r->post('/register', UserController::class);

        $r->get('/login', UserController::class);
        $r->post('/login', UserController::class);
    }
);

$middlewareQueue[] = new FastRoute($routes);
$middlewareQueue[] = $container->get(Auth::class);
$middlewareQueue[] = new RequestHandler($container);

$requestHandler = new Relay($middlewareQueue);
$response = $requestHandler->handle(ServerRequestFactory::fromGlobals());

$emitter = new SapiEmitter();

return $emitter->emit($response);
