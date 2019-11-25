<?php

namespace DragonQuiz\Controller;

use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Twig\Environment;

abstract class Controller
{
    protected $response;

    protected $twig;

    protected $em;

    public function __construct(ResponseInterface $response, Environment $twig, EntityManager $em) {
        $this->response = $response;
        $this->twig = $twig;
        $this->em = $em;
    }

    protected function responseHTML(string $body): ResponseInterface {
        $response = $this->response->withHeader('Content-Type', 'text/html');
        $response->getBody()->write($body);

        return $response;
    }
}
