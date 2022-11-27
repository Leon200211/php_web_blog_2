<?php


namespace Blog\Slim;


use Blog\Twig\AssetExtentsion;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Twig\Environment;


// обработка запросов вместе с реквестом
class TwigMiddleware implements MiddlewareInterface
{

    private Environment $environment;

    public function __construct(Environment $environment){
        $this->environment = $environment;
    }


    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // TODO: Implement process() method.
        // для корректного пути к файлам из любой точки сайта
        $this->environment->addExtension(new AssetExtentsion($request));
        return $handler->handle($request);
    }

}