<?php

namespace DragonQuiz\Controller;

use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Twig\Environment;

class UserController extends Controller
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
        $response = $this->response->withHeader('Content-Type', 'text/html');
        
			
			if($_SERVER['REQUEST_URI'] == '/register'){
			$name = '';
            $email ='';
			$password = '';
			$cpassword = '';
			
			if(count($_POST)>0){
				
			$name = $_POST['name'];
            $email = $_POST['email'];
			$password = $_POST['password'];
			$cpassword = $_POST['cpassword'];
				
			
			}
			
			
			
			
			$response->getBody()
            ->write($this->twig->render('register.html', ['name' => $name, 'password'=>$password,'cpassword'=>$cpassword, 'email'=>$email]));	
				
			}else{
				
				$response->getBody()
            ->write($this->twig->render('login.html', ['name' => 'Danniel']));
				
				
				
				
				
				
				
				
				
				
			}

        return $response;
		
		function register(){echo '<script>alert('foi')'}
    }
}
