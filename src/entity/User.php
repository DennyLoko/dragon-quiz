<?php

namespace DragonQuiz\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a single user in the app.
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User
{
    /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(name="id")
   */
    protected $id;

    /**
   * @ORM\Column(name="username")
   */
    protected $username;

    /**
   * @ORM\Column(name="email")
   */
    protected $email;

    /**
   * @ORM\Column(name="pass")
   */
    protected $pass;

    /**
     * @ORM\OneToMany(targetEntity="Score", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $scores;

    public function __construct() {
        $this->scores = new ArrayCollection();
    }

    // Returns ID of this User.

    public function getId()
    {
        return $this->id;
    }

    // Sets ID of this User.

    public function setId($id)
    {
        $this->id = $id;
    }

    // Returns username.

    public function getUsername()
    {
        return $this->username;
    }

    // Sets username.

    public function setUsername($username)
    {
        $this->username = $username;
    }

    // Returns email of this User.

    public function getEmail()
    {
        return $this->email;
    }

    // Sets ID of this User.

    public function setEmail($email)
    {
        $this->email = $email;
    }

    // Returns username.

    public function getPass()
    {
        return $this->pass;
    }

    // Sets username.

    public function setPass($pass)
    {
        $this->pass = $pass;
    }

    /**
     * @return Collection
     */
    public function getScores(): Collection
    {
        return $this->scores;
    }

    /**
     * @param Collection $scores
     */
    public function setScores(Collection $scores)
    {
        $this->scores = $scores;
    }

    public function addScore (int $points)
    {
        $score = new Score();
        $score->setPoints($points);
        $this->scores->add($score);
    }

    public function getLastScore ()
    {
        return $this->scores->last();
    }
}