<?php


namespace Blog;


use InvalidArgumentException;
use PDO;
use PDOException;


// класс для работы с БД
class Database
{
    private PDO $connection;

    public function __construct(PDO $connection){
        $this->connection = $connection;
    }



    public function getConnection() : PDO{
        return $this->connection;
    }

}