<?php


namespace Blog;

use PDO;

class LatestPosts
{

    private PDO $connection;


    /**
     * LatestPosts constructor.
     * @param PDO $connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }


    /**
     * @param int $limit
     * @return array|null
     */
    // вернуть последние посты
    public function getLastPosts(int $limit) : ?array{
        $statement = $this->connection->prepare("SELECT * FROM post ORDER BY published_date DESC LIMIT $limit");
        $statement->execute();

        return $statement->fetchAll();
    }


}