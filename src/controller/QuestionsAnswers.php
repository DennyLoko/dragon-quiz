<?php

namespace DragonQuiz\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\ResultSetMapping;
use http\Env\Response;
use Psr\Http\Message\ResponseInterface;
use Twig\Environment;
use Zend\Diactoros\Response\RedirectResponse;
use DragonQuiz\Entity\Question;
use DragonQuiz\Entity\Answer;

class QuestionsAnswers extends Controller
{
    private $response;
    private $twig;
    private $em;
    private $question;
    private $answers;
    private $points;
    private $user;


    public function __construct(ResponseInterface $response, Environment $twig, EntityManager $em)
    {
        $this->response = $response;
        $this->twig = $twig;
        $this->em = $em;
        $this->answers = [];
    }

    public function index()
    {
        $count = $this->em->getRepository(Question::class)->count([]);
        $random = mt_rand(1, $count);
        $question = $this->em->getRepository(Question::class)->findOneBy(['id' => $random]);

        $this->question = $question;
        $this->answers = $question->getAnswers();

        $response = $this->response->withHeader('Content-Type', 'text/html');
        $response
            ->getBody()
            ->write($this->twig->render('questions_answers.html', ['question' => $this->question, 'answers' => $this->answers]));

        return $response;
    }

    public function updatePoints()
    {
        // é o ID da questao
        $question = $_POST['question'];

        //usuario
        $conn = $this->em->getConnection();
        $sql = "SELECT id FROM user WHERE id = 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $this->user = $stmt->fetch();

        //pontos
        $conn = $this->em->getConnection();
        $sql = "SELECT * FROM points WHERE user_id = 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $this->points = $stmt->fetchAll();


        foreach ( $this->answers as $answer) {
            if ($_POST['answer'] == $answer['id']) {
                if ($answer['is_correct'] === 0) {
                    return 'Errou';
                }

                foreach ($this->points as $point) {
                    if ($point['user_id'] == $this->user['id']) {
                        if ($this->question['id'] == $question) {
                            $question = $this->question;

                            $this->points['points'] += $question['points'];

                            $response = new RedirectResponse('jogo');

                            return $response;
                        }
                    }
                }
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
