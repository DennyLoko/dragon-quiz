<?php

namespace DragonQuiz\controller;

use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\RedirectResponse;

class Logout extends Controller
{
    public function doLogout() : ResponseInterface {
        setcookie('dbz_user_email', '');
        setcookie('dbz_user_token', '');
        session_destroy();

        return new RedirectResponse('/');
    }
}
