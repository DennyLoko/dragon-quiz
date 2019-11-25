<?php

namespace DragonQuiz\Controller;

use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Twig\Environment;

class menu extends Controller
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
        $cookies = getCookieParams();

        $response = $this->response->withHeader('Content-Type', 'text/html');

        $response->getBody()
            ->write($this->twig->render('menu.html', ['cookie' => $cookies]));

        return $response;

    }

}
