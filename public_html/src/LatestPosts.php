<?php


namespace Blog;

use Blog\Database;


class LatestPosts
{

    private Database $database;



    public function __construct(Database $database)
    {
        $this->database = $database;
    }



    // вернуть последние посты
    public function getLastPosts(int $limit) : ?array{
        $statement = $this->database->getConnection()->prepare("SELECT * FROM post ORDER BY published_date DESC LIMIT $limit");
        $statement->execute();

        return $statement->fetchAll();
    }


}