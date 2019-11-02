<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

use \DI\ContainerBuilder;
use function DI\create;
use \DragonQuiz\Controller\HelloWorld;

$containerBuilder = new ContainerBuilder();
$containerBuilder->useAutowiring(false);
$containerBuilder->useAnnotations(false);

$containerBuilder->addDefinitions([
    HelloWorld::class => create(HelloWorld::class)
]);

$container = $containerBuilder->build();

$helloWorld = $container->get(HelloWorld::class);
$helloWorld->run();
