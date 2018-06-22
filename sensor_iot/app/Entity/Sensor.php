<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
  *@ORM\Entity
  *@ORM\Table(name="sensor")
  *@ORM\Entity(repositoryClass="App\Repository\SensorRepository")
  *@ORM\HasLifecycleCallbacks()
  */
class Sensor {

	/**
	*@var integer $id
	*@ORM\Column(name="id", type="integer", unique=true, nullable=false)
	*@ORM\Id
	*@ORM\GeneratedValue(strategy="AUTO")
	*/
	private $id;

	/**
	 * @ORM\Column(type="string")
	 */
	private $name;

	public function getId() {
	  return $this->id;
	}

	public function getName() {
	  return $this->name;
	}

	public function setName($name) {
	  $this->name = $name;
	}
}
