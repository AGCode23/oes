<?php

namespace App\Models;

use App\Core\Database;


class BaseModel
{
    protected $db;

    public function __construct()
    {
        $dbHost = $_ENV['DB_HOST'];
        $dbDatabase = $_ENV['DB_DATABASE'];
        $dbUser = $_ENV['DB_USER'];
        $dbPass = $_ENV['DB_PASS'];
        $this->db = Database::getInstance($dbHost, $dbDatabase, $dbUser,  $dbPass);
    }
}
