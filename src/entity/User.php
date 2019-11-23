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

    public function getusername() 

    {

        return $this->username;

    }



    // Sets username.

    public function setusername($username) 

    {

        $this->username = $username;

    }





    // Returns email of this User.

    public function getemail() 

    {

        return $this->email;

    }



    // Sets ID of this User.

    public function setemail($email) 

    {

        $this->email = $email;

    }



    // Returns username.

    public function getpass() 

    {

        return $this->pass;

    }



    // Sets username.

    public function setpass($pass) 

    {

        $this->pass = $pass;

    }

}