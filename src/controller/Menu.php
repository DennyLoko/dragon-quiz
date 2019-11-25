<?php

namespace DragonQuiz\Controller;

use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Twig\Environment;

class Menu extends Controller
{
    public function __invoke(): ResponseInterface {
        $isAdmin = $_SESSION['isAdmin'];
		
		$user = $this->em->getRepository('DragonQuiz\Entity\User')
                ->findOneBy(['email' => $_COOKIE['dbz_user_email']]);
		

        return $this->responseHTML($this->twig->render('menu.html', ['isAdmin' => $isAdmin, 'name' => $user->getUsername()]));
    }
}
