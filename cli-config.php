<?php
/**
 * Created by PhpStorm.
 * User: papilin.es
 * Date: 29.08.2019
 * Time: 19:45
 */
use Doctrine\ORM\Tools\Console\ConsoleRunner;

// replace with file to your own project bootstrap
require_once 'bootstrap.php';

// replace with mechanism to retrieve EntityManager in your app
$entityManager = GetEntityManager();

return ConsoleRunner::createHelperSet($entityManager);