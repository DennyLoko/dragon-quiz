<?php
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Dotenv\Dotenv;

$dotenv = Dotenv::create(__DIR__);
$dotenv->load();

$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;

$config = Setup::createAnnotationMetadataConfiguration(
    [__DIR__ . '/src/entity'],
    $isDevMode,
    $proxyDir,
    $cache,
    $useSimpleAnnotationReader
);

$conn = array(
    'driver' => 'pdo_mysql',
    'dbname' => getenv('MYSQL_DATA'),
    'user' => getenv('MYSQL_USER'),
    'password' => getenv('MYSQL_PASS'),
    'host' => getenv('MYSQL_HOST'),
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);
