<?php

namespace DragonQuiz\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="points")
 */
class Point
{

  /**
  * @ORM\Id
  * @ORM\Column(type="integer")
  * @ORM\GeneratedValue
  */
  protected $id;


  /**
   * @ORM\Column(type="integer")
   */
  protected $points;


  /**
   * @ORM\ManyToOne(targetEntity="User", inversedBy="points")
   * @ORM\joinColumn(name="user_id", referencedColumnName="id")
   */
  protected $user;

	 /**
    * @return mixed
    */
   public function getId(){
      return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id){
      $this->id = $id;
    }

    /**
     * @return int
     */
    public function getPoints(){
      return $this->points;
    }
    
    /**
     * @param int $points
     */
    public function setPoints(int $points){
      $this->points = $points;
    }


    /**
     * @return mixed
     */
    public function getUser(){
      return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user){
      $this->user = $user;
    }

}