<?php

namespace DragonQuiz\Controller;

use Psr\Http\Message\ResponseInterface;
use Twig\Environment;

class Ranking extends Controller
{
    private $response;
    private $twig;

    public function __construct(ResponseInterface $response, Environment $twig) {
        $this->response = $response;
        $this->twig = $twig;
    }

    public function __invoke(): ResponseInterface
    {
        $users = ['Danniel', 'Guilherme'];

        $response = $this->response->withHeader('Content-Type', 'text/html');
        $response->getBody()
            ->write($this->twig->render('ranking.html', ['users' => $users]));

        return $response;
    }
}
