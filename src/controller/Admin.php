<?php

namespace DragonQuiz\Controller;

use DragonQuiz\Entity\Question;
use Psr\Http\Message\ResponseInterface;

class Admin extends Controller
{
    public function __invoke(): ResponseInterface {
        if (count($_POST) > 0) {
            $question = new Question();
            $question->setQuestion($_POST["question"]);
            $question->setPoints($_POST["points"]);

            foreach ($_POST['answer'] as $i => $answer) {
                if ($answer != "") {
                    $question->addAnswer($answer, (int)$_POST["iscorrect"][$i]);
                }
            }

            $this->em->persist($question);
            $this->em->flush();
        }

        return $this->responseHTML($this->twig->render('Admin.html'));
    }
}
