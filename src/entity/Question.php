<?php

namespace DragonQuiz\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="questions")
 */
class Question
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $question;

    /**
     * @ORM\Column(type="integer")
     */
    protected $points;

    /**
     * @ORM\OneToMany(targetEntity="Answer", mappedBy="question", cascade={"persist", "remove"})
     */
    protected $answers;

    public function __construct() {
        $this->answers = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getQuestion() {
        return $this->question;
    }

    /**
     * @param string $question
     */
    public function setQuestion($question) {
        $this->question = $question;
    }

    /**
     * @return int
     */
    public function getPoints() {
        return $this->points;
    }

    /**
     * @param int $points
     */
    public function setPoints(int $points) {
        $this->points = $points;
    }

    /**
     * @return Collection
     */
    public function getAnswers(): Collection {
        return $this->answers;
    }

    /**
     * @param Collection $answers
     */
    public function setAnswers(Collection $answers) {
        $this->answers = $answers;
    }

    public function addAnswer(string $_answer, int $isCorrect) {
        $answer = new Answer();
        $answer->setAnswer($_answer);
        $answer->setIsCorrect($isCorrect);
        $answer->setQuestion($this);
        $this->answers->add($answer);
    }
}
