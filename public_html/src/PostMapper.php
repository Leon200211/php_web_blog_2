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
    // возвращает пост по переданному ключу
    public function getByUrlKey(string $urlKey) : ?array {
        $statement = $this->connection->prepare("SELECT * FROM post WHERE url_key = :urlKey");

        $statement->execute([
            'urlKey' => $urlKey
        ]);

        $result = $statement->fetchAll();

        // получаем первый элемент
        return array_shift($result);
    }


    /**
     * @param int $page
     * @param int $limit
     * @param string $direction
     * @return array|null
     * @throws \Exception
     */
    // метод возвращает массив постов
    public function getList(int $page = 1, $limit = 2, string $direction = "ASC") : ?array {

        if(!in_array($direction, ['ASC', 'DESC'])){
            throw new \Exception(("The direction is not supported"));
        }

        $start = ($page - 1) * $limit;

        $statement = $this->connection->prepare("SELECT * FROM post ORDER BY published_date $direction LIMIT $start, $limit ");
        $statement->execute();

        return $statement->fetchAll();
    }



    // общее число постов, которые мы собираемся отрисовывать
    public function getTotalCount() {
        $statement = $this->connection->prepare("SELECT count(post_id) as total FROM post");
        $statement->execute();

        // если результат есть, то вернуть, в противном случае вернуть 0
        return (int) ($statement->fetchColumn() ?? 0);
    }

}