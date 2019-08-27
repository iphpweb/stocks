<?php
/**
 * Created by PhpStorm.
 * User: papilin.es
 * Date: 27.08.2019
 * Time: 18:22
 */

return [
    'name' => 'Project \"Stocks\" Migrations',
    'migrations_namespace' => 'StocksApp\Migrations',
    'table_name' => 'migration_control_versions',
    'column_name' => 'version',
    'column_length' => 14,
    'executed_at_column_name' => 'executed_at',
    'migrations_directory' => __DIR__ . '/lib/StocksApp/Migrations',
    'all_or_nothing' => true,
    //'check_database_platform' => false
];