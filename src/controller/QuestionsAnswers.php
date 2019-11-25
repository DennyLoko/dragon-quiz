<?php

namespace DragonQuiz\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\ResultSetMapping;
use DragonQuiz\Entity\User;
use http\Env\Response;
use PhpParser\Node\Stmt\Return_;
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


    public function __construct(ResponseInterface $response, Environment $twig, EntityManager $em)
    {
        $this->response = $response;
        $this->twig = $twig;
        $this->em = $em;
        $this->answers = [];
    }

    public function index()
    {
        if (isset($_SESSION['question_count']) && $_SESSION['question_count'] == 5) {
            return new RedirectResponse('admin');
        }

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

    public function updatePoints(): RedirectResponse
    {
        if (!isset($_SESSION['question_count'])) {
            $_SESSION['question_count'] = 0;
        }

        $_SESSION['question_count']++;

        $answerId = $_POST['answer'];

        $user = $this->em
            ->getRepository(User::class)
            ->findOneBy(['email' => $_COOKIE['dbz_user_email']]);

        $answer = $this->em
            ->getRepository(Answer::class)
            ->findOneBy(['id' => $answerId]);

        if (!$answer->getIsCorrect()) {
            return new RedirectResponse('jogo');
        }

        $points = $answer->getQuestion()->getPoints();

        $user->getLastScore()->incrementScore($points);

        $this->em->persist($user);
        $this->em->flush();
        $this->em->clear();

        return new RedirectResponse('jogo');
    }
}
