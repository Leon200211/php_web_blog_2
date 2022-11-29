<?php


namespace Blog\Twig;

use Twig\TwigFunction;



// класс отвечает за создание Twig функций
class TwigFunctionFactory
{

    public function create(...$arguments): TwigFunction{
        return new TwigFunction(...$arguments);
    }

}