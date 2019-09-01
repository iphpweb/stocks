<?php
/**
 * Created by PhpStorm.
 * User: papilin.es
 * Date: 29.08.2019
 * Time: 19:46
 */
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

include_once __DIR__ . '/env.php';
include_once __DIR__ . '/config/db.php';

require_once __DIR__ . '/vendor/autoload.php';

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(
    [DOCUMENT_ROOT . "/lib/StocksApp/Entity"], // "/path/to/entity-files"
    $isDevMode
);

// database configuration parameters
$db_params = [
    'dbname' => DB_NAME,
    'user' => DB_USER,
    'password' => DB_PASS,
    'host' => DB_HOST,
    'driver' => 'pdo_mysql'
];

// obtaining the entity manager
$entityManager = EntityManager::create($db_params, $config);