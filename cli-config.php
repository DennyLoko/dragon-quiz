<?php
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once __DIR__ . '/bootstrap.php';

return ConsoleRunner::createHelperSet($entityManager);
