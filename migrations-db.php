<?php
/**
 * Created by PhpStorm.
 * User: papilin.es
 * Date: 27.08.2019
 * Time: 18:26
 */
include_once __DIR__ . '/env.php';
include_once __DIR__ . '/config/db.php';

return [
    'dbname' => DB_NAME,
    'user' => DB_USER,
    'password' => DB_PASS,
    'host' => DB_HOST,
    'driver' => 'pdo_mysql'
];