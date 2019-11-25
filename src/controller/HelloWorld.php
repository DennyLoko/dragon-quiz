<?php

namespace DragonQuiz\Controller;

use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Twig\Environment;

class HelloWorld extends Controller
{
    private $response;
    private $twig;
    private $em;

    public function __construct(ResponseInterface $response, Environment $twig, EntityManager $em) {
        $this->response = $response;
        $this->twig = $twig;
        $this->em = $em;
    }

    public function __invoke(): ResponseInterface
    {
        $response = $this->response->withHeader('Content-Type', 'text/html');
        $response->getBody()
            ->write($this->twig->render('hello_world.html', ['name' => 'Danniel']));

        return $response;
    }
}
