<?php

namespace DragonQuiz\Controller;

use DragonQuiz\Entity\Score;
use Exception;
use Psr\Http\Message\ResponseInterface;

class Ranking extends Controller
{
    public function __invoke(): ResponseInterface {
        try {
            $points = $this->em->getRepository(Score::class)->findBy([], ['points' => 'Desc']);
        } catch (Exception $ex) {
            $points = "Error: ".$ex;
        }

        return $this->responseHTML($this->twig->render('Ranking.html', ['ranking' => $points]));
    }
}
