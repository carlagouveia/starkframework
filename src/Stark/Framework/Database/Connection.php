<?php

namespace Stark\Framework\Database;

class Connection
{
    protected $pdo;

    public function __construct($driver, $host, $database, $user, $password)
    {
        $dsn = "$driver:host=$host";

        if ($database) {
            $dsn .= ";dbname=$database;charset=utf8";
        }

        $this->pdo = new \PDO($dsn, $user, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}