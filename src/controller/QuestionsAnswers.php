<?php

namespace DragonQuiz\Controller;

use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Twig\Environment;

class QuestionsAnswers extends Controller
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

    public function index(): ResponseInterface
    {
        $question = str_shuffle ('My dick' );

        $answers = [
            "Piccolo",
            "Goku",
            "Vegeta",
        ];

        $response = $this->response->withHeader('Content-Type', 'text/html');
        $response
            ->getBody()
            ->write($this->twig->render('questions_answers.html', ['question' => $question, 'answers' => $answers]));

        return $response;
    }

    public function update($answer, $request)
    {
        $answer = $request->input;

        $response = $this->response->withHeader('Content-Type', 'text/html');
        $response
            ->getBody()
            ->write($this->twig->render('questions_answers.html'));

        return $response;
    }
}
