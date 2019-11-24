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

    public function __construct(ResponseInterface $response, Environment $twig, EntityManager $em) {
        $this->response = $response;
        $this->twig = $twig;
        $this->em = $em;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $cookies = $request->getCookieParams();

        if (!(isset($cookies['dbz_user_email']) && isset($cookies['dbz_user_token']))
        && ($cookies['dbz_user_email'] == "" || $cookies['dbz_user_token'] == "")) {

            return header('location: login.html?if=1');

        }

        $user = $this->em->getRepository('User')
             ->findOneBy(['email' => $cookies['dbz_user_email']]);

        if ($user == null) {

            return header('location: login.html?if=2');

        }

        $token = md5($user->getUsername().$user->getPass());

        if ($cookies['dbz_user_token'] != $token) {

            return header('location: login.html?if=3');

        }
        
        return $handler->handle($request);
    }
}