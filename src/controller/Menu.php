<?php

namespace DragonQuiz\Controller;

use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Twig\Environment;

class Menu extends Controller
{
    public function __invoke(): ResponseInterface {
        $isAdmin = $_SESSION['isAdmin'];

        return $this->responseHTML($this->twig->render('menu.html', ['isAdmin' => $isAdmin]));
    }
}
