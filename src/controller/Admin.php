<?php

namespace DragonQuiz\Controller;

use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Twig\Environment;
use DragonQuiz\Entity\Question;

class Admin extends Controller
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
        if (count ($_POST)>0){
            $question=new Question();
            $question->setQuestion($_POST["question"]);
            $question->setPoints($_POST["points"]);
            
            foreach($_POST['answer'] as $i => $answer){
                if ($answer!=""){
                    $question->addAnswer($answer,(int) $_POST["iscorrect"][$i]);
                }
            }

            $this->em->persist($question);
            $this->em->flush();
        }        

        $response = $this->response->withHeader('Content-Type', 'text/html');
        $response->getBody()
            ->write($this->twig->render('Admin.html'));

        return $response;                
    }
}
