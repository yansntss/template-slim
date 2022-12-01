<?php

namespace App\DAO\MySQL\qualihelp;

abstract class Conexao
{
    /**
     * @var \PDO
     */
    protected $pdo;

    public function __construct()
    {
        $host = getenv('QUALIHELP_HOST');
        $port = getenv('QUALIHELP_DBNAME');
        $user = getenv('QUALIHELP_USER');
        $pass = getenv('QUALIHELP_PASSWORD');
        $dbname =getenv('QUALIHELP_DBNAME');


        $dsn = "mysql:host={$host};dbname={$dbname};port={$port}";

        $this->pdo = new \PDO($dsn, $user, $pass);
        $this->pdo->setAttribute(
            \PDO::ATTR_ERRMODE,
            \PDO::ERRMODE_EXCEPTION
        );
    }
}
