<?php

namespace DragonQuiz\Controller;

use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use DragonQuiz\Entity\User;
use Twig\Environment;

class UserController extends Controller
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

    function register($name, $email, $password, $cpassword)
    {

        if ($password == $cpassword) {
            $u = new User();
            $u->setUsername($name);
            $u->setEmail($email);
            $u->setPass(md5($password));
            try {
                $this
                    ->em
                        ->persist($u);

                $this
                    ->em
                        ->flush();

                $this
                    ->em
                        ->clear();

                echo "<script>alert('Cadastrado com Sucesso')</script>";

            } catch (\Exception $erro) {
                //echo $erro->getMessage();
                if ($erro->getErrorCode() == '1062') {

                    $array = explode('key', $erro->getMessage());
                    if ($array[1] == " 'username_UNIQUE'") {

                        echo "<script>alert('Usuario já cadastrado');</script>
						<style type='text/css'>#name{border-color:red;}</style>";
                    }
                    if ($array[1] == " 'email_UNIQUE'") {

                        echo "<script>alert('Email já cadastrado');</script>
						<style type='text/css'>#email{border-color:red;}</style>";
                    }
                } else if ($erro->getErrorCode() == '2002') {

                    echo "<script>alert('Falha na conexão');</script>";
                }
            }
        } else {

            echo "<script>alert('A senha não coincide');</script>
			<style type='text/css'>#cpassword{border-color:red;}</style>";
        }
    }

    public function __invoke(): ResponseInterface
    {
        $response = $this
            ->response
                ->withHeader('Content-Type', 'text/html');

        if ($_SERVER['REQUEST_URI'] == '/register') {
            $name = '';
            $email = '';
            $password = '';
            $cpassword = '';

            if (count($_POST) > 0) {

                $name = $_POST['name'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $cpassword = $_POST['cpassword'];

                $this->register($name, $email, $password, $cpassword);
            }

            $response->getBody()
                ->write($this
                    ->twig
                        ->render('register.html', ['name' => $name, 'password' => $password, 'cpassword' => $cpassword, 'email' => $email]));
        } else {

            $response->getBody()
                ->write($this
                    ->twig
                        ->render('login.html', ['name' => 'Danniel']));
        }

        return $response;
    }
}
