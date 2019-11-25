<?php

namespace DragonQuiz\Controller;

use DragonQuiz\Entity\Question;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\RedirectResponse;

class Admin extends Controller
{
    public function form(): ResponseInterface {
        return $this->responseHTML($this->twig->render('Admin.html'));
    }

    public function save() : ResponseInterface {
        $question = new Question();
        $question->setQuestion($_POST["question"]);
        $question->setPoints($_POST["points"]);

        foreach ($_POST['answer'] as $i => $answer) {
            if ($answer != "") {
                $question->addAnswer($answer, (int)$_POST["is_correct"][$i]);
            }
        }

        $this->em->persist($question);
        $this->em->flush();

        return new RedirectResponse('admin');
    }
}
