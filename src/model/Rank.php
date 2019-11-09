<?php
namespace DragonQuiz\Model;

class Rank
{

  private $users = array();

  public function __construct()
  { 
    
  }

  public function __set($property,$value){
    $this->$property = $value;
  }

  public function __get($value){
    return $this->$value;
  }

}
