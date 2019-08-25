<?php

final class Database
{
    // specify your own database credentials
    private static $db_host = DB_HOST;
    private static $db_name = DB_NAME;
    private static $db_user = DB_USER;
    private static $db_pass = DB_PASS;

    private static $instance;

    // get the database connection
    public static function getInstance()
    {
        if (self::$instance == null) {
            try {
                self::$instance = new PDO("mysql:host=".self::$db_host.";dbname=".self::$db_name, self::$db_user, self::$db_pass);
            } catch (PDOException $exception) {
                echo "Connection error: " . $exception->getMessage();
            }
        }
        
        return self::$instance;
    }

    /**
     * is not allowed to call from outside to prevent from creating multiple instances,
     * to use the singleton, you have to obtain the instance from Singleton::getInstance() instead
     */
    private function __construct()
    {
    }

    /**
     * prevent the instance from being cloned (which would create a second instance of it)
     */
    private function __clone()
    {
    }

    /**
     * prevent from being unserialized (which would create a second instance of it)
     */
    private function __wakeup()
    {
    }
}

