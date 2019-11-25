<?php

namespace DragonQuiz\Controller;

use Doctrine\ORM\EntityManager;
use DragonQuiz\Entity\User;
use DragonQuiz\Entity\Score;
use Psr\Http\Message\ResponseInterface;
use Twig\Environment;

class UserController extends Controller
{
	function firstscore($name){
		
		//$user = $this->em->getRepository(User::class)->findOneBy(['email' => $name]);
		
		
        try {
		$conn = $this->em->getConnection();

            $sql = "INSERT INTO scores (user_id, points) VALUES(".$name->getId().", 0);";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

           
			 } catch (\Exception $erro) {
			 echo $erro->getMessage();	
			 exit;}
		

         
	}
    function register($name, $email, $password, $cpassword) {
        if ($password == $cpassword) {
            $u = new User();
            $u->setUsername($name);
            $u->setEmail($email);
            $u->setPass(md5($password));
            try {
                $this->em->persist($u);
                $this->em->flush();
                $this->em->clear();
				$this->firstscore($u);
                //cookies
                echo "<script>alert('Cadastrado com Sucesso')</script>";
                setcookie("dbz_user_email", $u->getEmail());
                setcookie("dbz_user_token", md5($u->getUsername().$u->getPass()));
                echo "<meta http-equiv='refresh' content='0; url=/dragon-quiz/public/'>";
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
                } else {
                    if ($erro->getErrorCode() == '2002') {
                        echo "<script>alert('Falha na conexão');</script>";
                    }
                }
            }
        } else {
            echo "<script>alert('A senha não coincide');</script>
				  <style type='text/css'>#cpassword{border-color:red;}</style>";
        }
    }

    function login($name, $password) {
        try {
            $conn = $this->em->getConnection();

            $sql = "SELECT * FROM user WHERE username = '".$name."' OR email = '".$name."'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $u = $stmt->fetch();

            if ($u != null) {

                if ($u["pass"] == md5($password)) {
                    setcookie("dbz_user_email", $u["email"]);
                    setcookie("dbz_user_token", md5($u["username"].$u["pass"]));
                    echo "<meta http-equiv='refresh' content='0; url=/dragon-quiz/public/'>";
                } else {
                    echo "<script>alert('Senha incorreta');</script>
				  <style type='text/css'>#password{border-color:red;}</style>";
                }
            } else {
                echo "<script>alert('Usuário não cadastrado');</script>
				  <style type='text/css'>#name{border-color:red;}</style>";
            }
        } catch (\Exception $erro) {
            echo $erro;
        }
    }

    public function __invoke(): ResponseInterface {
        $response = $this->response->withHeader('Content-Type', 'text/html');

        if ($_SERVER['REQUEST_URI'] == '/register') {
            $name = '';
            $email = '';

            if (count($_POST) > 0) {

                $name = $_POST['name'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $cpassword = $_POST['cpassword'];

                $this->register($name, $email, $password, $cpassword);
            }

            $response->getBody()->write(
                    $this->twig->render('register.html', ['name' => $name, 'email' => $email])
                );
        } else {
            $name = '';

            if (count($_POST) > 0) {

                $name = $_POST['name'];
                $password = $_POST['password'];

                $this->login($name, $password);
            }

            $response->getBody()->write(
                    $this->twig->render('login.html', ['name' => $name])
                );
        }

        return $response;
    }
}
