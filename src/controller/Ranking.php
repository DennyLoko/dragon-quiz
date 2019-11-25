<?php

namespace DragonQuiz\Controller;

use DragonQuiz\Entity\Score;
use Exception;
use Psr\Http\Message\ResponseInterface;

class Ranking extends Controller
{
    public function __invoke(): ResponseInterface {
        try {
            $showpoints = '';

            if (isset($_SESSION['question_count']) && $_SESSION['question_count'] > 0) {
                $_SESSION['question_count'] = 0;

                $user = $this->em->getRepository('DragonQuiz\Entity\User')->findOneBy(
                        ['email' => $_COOKIE['dbz_user_email']]
                    );

                $userpoints = $user->getLastScore();
                $showpoints = $userpoints->getPoints();
            }

            $points = $this->em->getRepository(Score::class)->findBy([], ['points' => 'Desc']);
        } catch (Exception $ex) {
            echo $ex;
            $points = "Error: ".$ex;
        }

        return $this->responseHTML(
            $this->twig->render('Ranking.html', ['ranking' => $points, 'pontuacao' => $showpoints])
        );
    }
}
