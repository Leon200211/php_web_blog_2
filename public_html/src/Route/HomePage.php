<?php


namespace Blog\Route;

use Blog\Database;
use Blog\LatestPosts;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Twig\Environment;

// класс для роутинга на домашнюю страницу
class HomePage
{

    private LatestPosts $latestPosts;
    private Environment $view;


    public function __construct(LatestPosts $latestPosts, Environment $view){
        $this->latestPosts = $latestPosts;
        $this->view = $view;
    }



    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function execute(Request $request, Response $response) : Response {
        $posts = $this->latestPosts->getLastPosts(3);
        $body = $this->view->render('index.twig', [
            'posts' => $posts
        ]);
        $response->getBody()->write($body);
        return $response;
    }

}