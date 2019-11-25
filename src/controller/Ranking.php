<?php

namespace DragonQuiz\Controller;

use Doctrine\ORM\EntityManager;
use DragonQuiz\Entity\Point;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Twig\Environment;

class Ranking extends Controller
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

  public function __invoke(): ResponseInterface
  {
    try {
      $points = $this->em->getRepository(Point::class)->findBy(array(), array('points' => 'Desc'));
    } catch (Exception $ex) {
      $points = "Error: " . $ex;
    }

    $response = $this->response->withHeader('Content-Type', 'text/html');
    $response->getBody()->write($this->twig->render('Ranking.html', ['ranking' => $points]));

    return $response;
  }
}
