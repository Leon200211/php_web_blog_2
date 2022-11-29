<?php


namespace Blog\Twig;

use Twig\Extension\AbstractExtension;


// класс который будет использовать Twig
// для корректного пути к файлам из любой точки сайта
class AssetExtentsion extends AbstractExtension
{

    private array $serverParams;
    private TwigFunctionFactory $twigFunctionFactory;

    public function __construct(array $serverParams, TwigFunctionFactory $twigFunctionFactory){
        $this->serverParams = $serverParams;
        $this->twigFunctionFactory = $twigFunctionFactory;
    }


    public function getFunctions()
    {
        // для создание экземпляров используем паттерн фабрики
        return [
            $this->twigFunctionFactory->create('asset_url', [$this, 'getAssetUrl']),
            $this->twigFunctionFactory->create('url', [$this, 'getUrl']),
            $this->twigFunctionFactory->create('base_url', [$this, 'getBaseUrl']),
        ];
    }

    /**
     * @return string
     */
    public function getBaseUrl() : string {
        $scheme = $this->serverParams['REQUEST_SCHEME'] ?? 'http';
        return $scheme . "://" . $this->serverParams['HTTP_HOST'] . '/';
    }

    /**
     * @param string $path
     * @return string
     */
    public function getAssetUrl(string $path) : string{
        //return 'http://fitlent.web.blog.two/' . $path;
        return $this->getBaseUrl() . $path;
    }


    /**
     * @param string $path
     * @return string
     */
    public function getUrl(string $path) : string {
        return $this->getBaseUrl() . $path;
    }

}