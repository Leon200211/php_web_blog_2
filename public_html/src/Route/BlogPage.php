<?php


namespace Blog\Route;


use Blog\PostMapper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;


// класс для роутинга на страницу блога
class BlogPage
{

    private Environment $view;
    private PostMapper $postMapper;


    public function __construct(Environment $view, PostMapper $postMapper) {
        $this->view = $view;
        $this->postMapper = $postMapper;
    }


    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response) : ResponseInterface {

        // проверяем на какой страницы находится пагинация
        $page = isset($args['page']) ? (int) $args['page'] : 1;
        // количество постов на странице
        $limit = 2;

        $posts = $this->postMapper->getList($page, $limit, "DESC");

        $totalCount = $this->postMapper->getTotalCount();

        $body = $this->view->render('blog.twig', [
            'posts' => $posts,
            'pagination' => [
                'current' => $page,
                'paging' => ceil($totalCount / $limit)
            ]
        ]);
        $response->getBody()->write($body);
        return $response;
    }

}