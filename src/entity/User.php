<?php 

namespace DragonQuiz\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="users")
*/
class User
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
    protected $username;
	
	 /**
    * @ORM\Column(type="string")
    */
    protected $email;
	
	 /**
    * @ORM\Column(type="string")
    */
		protected $pass;
		

		/**
		 * @ORM\OneToMany(targetEntity="Point", mappedBy="user")
		 */
		protected $points;
	
		
		public function __construct(){
			$this->points = new ArrayCollection();
		}
		

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
		 * @return string
		 */
		public function getUsername(): string{
			return $this->username;
		}

		/**
		 * @param string $username
		 */
		public function setUsername(string $username){
			$this->username = $username;
		}


		/**
		 * @return string
		 */
		public function getEmail(): string{
			return $this->email;
		}

		/**
		 * @param string $email
		 */
		public function setEmail(string $email){
			$this->email = $email;
		}


		/**
		 * @return string
		 */
		public function getPass(): string{
			return $this->pass;
		}

		/**
		 * @param string $pass
		 */
		public function setPass(string $pass){
			$this->pass = $pass;
		}

		/**
		 * @return Collection
		 */
		public function getPoints(): Collection{
			return $this->points;
		}

		/**
		 * @param Collection $points
		 */
		public function setPoints(Collection $points){
			$this->points = $points;
		}
}





