<?php

namespace Blog;

use PDO;

// класс для работы с БД
class PostMapper
{

    /**
     * @var PDO
     */
    private PDO $connection;


    /**
     * PostMapper constructor.
     * @param PDO $connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param string $urlKey
     * @return array|null
     */
    public function getByUrlKey(string $urlKey) : ?array {
        $statement = $this->connection->prepare("SELECT * FROM post WHERE url_key = :urlKey");

        $statement->execute([
            'urlKey' => $urlKey
        ]);

        $result = $statement->fetchAll();

        // получаем первый элемент
        return array_shift($result);
    }

}