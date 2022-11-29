<?php


namespace Blog\Route;


// для обработки исключений и hru поиска
use Blog\PostMapper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;

class PostPage
{

    private Environment $view;
    private PostMapper $postMapper;


    /**
     * PostPage constructor.
     * @param Environment $view
     * @param PostMapper $postMapper
     */
    public function __construct(Environment $view, PostMapper $postMapper) {
        $this->view = $view;
        $this->postMapper = $postMapper;
    }



    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []) : ResponseInterface {

        $post = $this->postMapper->getByUrlKey((string) $args['url_key']);

        if(empty($post)){
            $body = $this->view->render('not-found.twig', [
                'post' => $args['url_key']
            ]);
        }else{
            $body = $this->view->render('post.twig', [
                'post' => $post
            ]);
        }

        $response->getBody()->write($body);
        return $response;

    }


}