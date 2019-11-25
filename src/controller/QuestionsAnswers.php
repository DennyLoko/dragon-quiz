<?php

namespace DragonQuiz\Controller;

use DragonQuiz\Entity\Answer;
use DragonQuiz\Entity\Question;
use DragonQuiz\Entity\User;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\RedirectResponse;

class QuestionsAnswers extends Controller
{
    public function index(): ResponseInterface {
        if (isset($_SESSION['question_count']) && $_SESSION['question_count'] == 5) {
            return new RedirectResponse('ranking');
        }

        $count = $this->em->getRepository(Question::class)->count([]);

        if ($count == 0) {
            return $this->responseHTML(
                $this->twig->render(
                    'no_questions.html'
                )
            );
        }

        $random = mt_rand(1, $count);
        $question = $this->em->getRepository(Question::class)->findOneBy(['id' => $random]);

        return $this->responseHTML(
            $this->twig->render(
                'questions_answers.html',
                [
                    'question' => $question,
                    'answers' => $question->getAnswers(),
                ]
            )
        );
    }

    public function updatePoints(): ResponseInterface {
        if (!isset($_SESSION['question_count'])) {
            $_SESSION['question_count'] = 0;
			//nova lina na tabela score
			try{
			$user = $this->em->getRepository(User::class)->findOneBy(['email' => $_COOKIE['dbz_user_email']]);
			$conn = $this->em->getConnection();

            $sql = "INSERT INTO scores (user_id, points) VALUES(".$user->getId().", 0);";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

           
			 } catch (\Exception $erro) {
			 echo $erro->getMessage();	
			 exit;
			 }
        }

        $_SESSION['question_count']++;

        $answerId = $_POST['answer'];

        $user = $this->em->getRepository(User::class)->findOneBy(['email' => $_COOKIE['dbz_user_email']]);
        $answer = $this->em->getRepository(Answer::class)->findOneBy(['id' => $answerId]);

        if (!$answer->getIsCorrect()) {
            return new RedirectResponse('game');
        }

        $points = $answer->getQuestion()->getPoints();

        $user->getLastScore()->incrementScore($points);

        $this->em->persist($user);
        $this->em->flush();
        $this->em->clear();

        return new RedirectResponse('game');
    }
}
