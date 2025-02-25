<?php

namespace App\Core;

use PDO;


class Database
{
    private static $intance = null;
    private $pdo;

    private function __construct($host, $dbName, $dbUserName, $dbPassword)
    {
        try {
            $dsn = "mysql:host=$host;dbname=$dbName";
            $this->pdo = new PDO($dsn, $dbUserName, $dbPassword);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public static function getInstance($host, $dbName, $dbUserName, $dbPassword)
    {
        if (!self::$intance) {
            self::$intance = new Database($host, $dbName, $dbUserName, $dbPassword);
        }

        return self::$intance->pdo;
    }
}
