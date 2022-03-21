<?php

namespace App\Database;

use Doctrine\DBAL\DriverManager;

class Connection
{
    public static function connect()
    {
        return DriverManager::getConnection([
            'dbname' => $_ENV['DATABASE_NAME'],
            'user' => $_ENV['DATABASE_USER'],
            'host' => $_ENV['DATABASE_HOST'],
            'driver' => $_ENV['DATABASE_DRIVER'],
        ]);
    }
}