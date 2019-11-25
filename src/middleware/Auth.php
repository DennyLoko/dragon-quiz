<?php

namespace DragonQuiz\Middleware;

use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Twig\Environment;


class Auth implements MiddlewareInterface
{
    private $response;
    private $twig;
    private $em;

    public function __construct(ResponseInterface $response, Environment $twig, EntityManager $em)
    {
        $this->response = $response;
        $this->twig = $twig;
        $this->em = $em;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $cookies = $request->getCookieParams();

        if (!($_SERVER['REQUEST_URI'] == '/register' || $_SERVER['REQUEST_URI'] == '/login')) {

            $response = $this->response->withHeader('Content-Type', 'text/html');

            if (
                !(isset($cookies['dbz_user_email']) && isset($cookies['dbz_user_token']))
                && ($cookies['dbz_user_email'] == "" || $cookies['dbz_user_token'] == "")
            ) {

                return $response->getBody()
                    ->write($this->twig->render('login.html'));
            }

            $user = $this->em->getRepository('DragonQuiz\Entity\User')
                ->findOneBy(['email' => $cookies['dbz_user_email']]);

            if ($user == null) {

                return $response->getBody()
                    ->write($this->twig->render('login.html'));
            }

            $token = md5($user->getUsername() . $user->getPass());
            var_dump($token);

            if ($cookies['dbz_user_token'] != $token) {

                return $response->getBody()
                    ->write($this->twig->render('login.html'));
            }

            if ($user->get_username() == 'admin') {
                
                if (isset($cookies['is_admin'])) {
                    
                    setcookie('isAdmin','true');
                }
            }
        }

        return $handler->handle($request);
    }
}
