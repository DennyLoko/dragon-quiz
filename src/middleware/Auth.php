<?php

namespace DragonQuiz\Middleware;

use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Psr\Http\Server\MiddlewareInterface;
use Zend\Diactoros\Uri;
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
        $path = $request->getUri()->getPath();
        $cookies = $request->getCookieParams();

        if (!($path == '/register' || $path == '/login')) {

            $response = $this->response->withHeader('Content-Type', 'text/html');

            if (!(isset($cookies['dbz_user_email']) && isset($cookies['dbz_user_token']))) {

                return new RedirectResponse('login');

            }

            if ($cookies['dbz_user_email'] == "" || $cookies['dbz_user_token'] == "") {

                return new RedirectResponse('login');

            }

            $user = $this->em->getRepository('DragonQuiz\Entity\User')
                ->findOneBy(['email' => $cookies['dbz_user_email']]);

            if ($user == null) {

                return new RedirectResponse('login');

            }

            $token = md5($user->getUsername() . $user->getPass());

            if ($cookies['dbz_user_token'] != $token) {

                return new RedirectResponse('login');

            }

            if ($user->getUsername() == 'admin') {
                
                $_SESSION['isAdmin'] = true;

            }
        }

        return $handler->handle($request);
    }
}
