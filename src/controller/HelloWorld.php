<?php

namespace DragonQuiz\Controller;

use Psr\Http\Message\ResponseInterface;
use Twig\Environment;

class HelloWorld extends Controller
{
    private $response;
    private $twig;

    public function __construct(ResponseInterface $response, Environment $twig) {
        $this->response = $response;
        $this->twig = $twig;
    }

    public function __invoke(): ResponseInterface
    {
        $response = $this->response->withHeader('Content-Type', 'text/html');
        $response->getBody()
            ->write($this->twig->render('hello_world.html', ['name' => 'Danniel']));

        return $response;
    }
}
