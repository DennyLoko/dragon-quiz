<?php

namespace DragonQuiz\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a single user in the app.
 * @ORM\Entity
 * @ORM\Table(name="scores")
 */
class Score
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(name="integer")
     */
    protected $points;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="points")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

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
     * @return mixed
     */
    public function getPoints() {
        return $this->points;
    }

    /**
     * @param mixed $points
     */
    public function setPoints($points) {
        $this->points = $points;
    }

    /**
     * @return mixed
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user) {
        $this->user = $user;
    }

    public function incrementScore(int $points) {
        $this->points += $points;
    }
}
