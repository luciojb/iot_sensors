<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
  *@ORM\Entity()
  *@ORM\Table(name="sensor")
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
	 * @ORM\Column(type="string", nullable=false)
	 */
	private $name;

	/**
	 * @ORM\Column(name="last_active", type="datetimetz", nullable=false)
	 */
	private $lastActive;

	/**
     * One Sensor has One Latest Data.
     * @ORM\OneToOne(targetEntity="Data")
     * @ORM\JoinColumn(name="latest_data_readed", referencedColumnName="id")
     */
	private $latest_data;

	public function getId() {
	  return $this->id;
	}

	public function getName() {
	  return $this->name;
	}

	public function setName($name) {
	  $this->name = $name;
	}

	public function getLastActive() {
	    return $this->lastActive;
	}

	public function setLastActive($lastActive) {
	    $this->lastActive = $lastActive;
	    return $this;
	}

	      public function getLatestData() {
	    return $this->latest_data;
	}

	public function setLatestData($latest_data) {
	    $this->latest_data = $latest_data;
	    return $this;
	}

}
