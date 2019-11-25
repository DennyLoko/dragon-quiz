<?php

namespace DragonQuiz\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="answers")
 */
class Answer
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;
    /**
     * @ORM\Column(type="string")
     */
    protected $answer;
    /**
     * @ORM\Column(type="boolean")
     */
    protected $is_correct;
    /**
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="answers")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     */
    protected $question;
    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }
    /**
     * @param mixed $id
     */
    public function setId($id) {
        $this->id = $id;
    }
    /**
     * @return string
     */
    public function getAnswer(): string {
        return $this->answer;
    }
    /**
     * @param string $answer
     */
    public function setAnswer(string $answer) {
        $this->answer = $answer;
    }
    /**
     * @return mixed
     */
    public function getIsCorrect() {
        return $this->is_correct;
    }
    /**
     * @param mixed $is_correct
     */
    public function setIsCorrect($is_correct) {
        $this->is_correct = $is_correct;
    }
    /**
     * @return mixed
     */
    public function getQuestion() {
        return $this->question;
    }
    /**
     * @param mixed $question
     */
    public function setQuestion($question) {
        $this->question = $question;
    }
}


