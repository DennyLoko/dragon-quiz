<?php



namespace DragonQuiz\Entity;



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

}