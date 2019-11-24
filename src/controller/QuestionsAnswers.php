<?php

namespace DragonQuiz\Controller;

use Doctrine\ORM\EntityManager;
use DragonQuiz\Entity\Question;
use http\Env\Response;
use Psr\Http\Message\ResponseInterface;
use Twig\Environment;
use Zend\Diactoros\Response\RedirectResponse;

class QuestionsAnswers extends Controller
{
    private $response;
    private $twig;
    private $em;
    private $question;
    private $answers;
    private $user;
    private $points;

    public function __construct(ResponseInterface $response, Environment $twig, EntityManager $em)
    {
        $this->response = $response;
        $this->twig = $twig;
        $this->em = $em;

        $this->user = [
            'id' => 1,
            'username' => 'Yuri',
        ];

        $this->points = [
            'id' => 1,
            'points' => 0,
            'user_id' => 1,
        ];

        $this->question = [
            'id' => 1,
            'question' => 'Quem matou o goku na luta contra raditz?',
            'points' =>  3,
        ];

        $this->answers = [
            [
                'id' => 1,
                'answer' => 'Gohan',
                'is_correct' =>  0,
                'question_id' => 1,
            ],
            [
                'id' => 2,
                'answer' => 'Piccolo',
                'is_correct' =>  1,
                'question_id' => 1,
            ],
        ];
    }

    public function index(): ResponseInterface
    {
        //pegar uma pergunta aleatoria no banco e suas respostas
        //select * from answers where question_id = $question;

        $response = $this->response->withHeader('Content-Type', 'text/html');
        $response
            ->getBody()
            ->write($this->twig->render('questions_answers.html', ['question' => $this->question, 'answers' => $this->answers]));

        return $response;
    }

    public function updatePoints(): RedirectResponse
    {
        $answers = null;
        $question = $_POST['question'];

        foreach ( $this->answers as $answer) {
            if ($_POST['answer'] == $answer['id']) {
                $answers = $answer;
            }
        }

        if ($answers['is_correct'] === 0) {
            return 'Errou';
        }

        if ($this->points['user_id'] == $this->user['id']) {
            if ($this->question['id'] == $question) {
                $question = $this->question;

                $this->points['points'] += $question['points'];

                $response = new RedirectResponse('jogo');

                return $response;
            }
        }

        //$inputAnswer = $_POST['answer'];
        //$inputQuestion = $_POST['question'];
        //pegar resposta, ´nesse input pegou o ID da resposta´
        //resposta é igual a resposta correta da pergunta

        //$result = select is_correct from answers where id = $inputAnswer;
        // if ($result != 1) {
        //  return index;
        // }
        //$points = select points from questions where id = $inputQuestion;
        //Tenho que pegar o usuario logado naquele momento
        //update points set points += $points where user_id = $usuarioLogado;
        //return index;
    }
}
