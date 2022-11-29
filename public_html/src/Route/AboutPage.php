<?php


namespace Blog\Route;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;


// класс для роутинга на страницу о нас
class AboutPage
{
    private Environment $view;


    public function __construct(Environment $view) {
        $this->view = $view;
    }


    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function  __invoke(ServerRequestInterface $request, ResponseInterface $response) : ResponseInterface {

        $body = $this->view->render('about.twig', [
            'name' => 'leon'
        ]);
        $response->getBody()->write($body);
        return $response;

    }

}