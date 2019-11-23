<?php

namespace DragonQuiz\Entity;

use Doctrine\ORM\Mapping as ORM;



/**

 * @ORM\Entity(repositoryClass="DragonQuiz\Entity\User")

 */

class Article

{

    /**

     * @ORM\Id()

     * @ORM\GeneratedValue()

     * @ORM\Column(type="integer")

     */

    protected $id;



    /**

     * @ORM\Column(type="string", length=128)

     */

    protected $username;



    /**

     * @ORM\Column(type="string", length=128)

     */

    protected $email;



    /**

     * @ORM\Column(type="string", length=128 nullable=false)

     */

    protected $pass;



    /**

     * @ORM\Column(type="datetime")

     */

    protected $created_at;

	

	/**

     * @ORM\Column(type="datetime")

     */

    protected $updated_at;



}



?>