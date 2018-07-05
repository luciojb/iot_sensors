<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
  *@ORM\Entity()
  *@ORM\Table(name="sensor_data")
  *@ORM\HasLifecycleCallbacks()
  */
class Data {

	/**
	*@var integer $id
	*@ORM\Column(name="id", type="integer", unique=true, nullable=false)
	*@ORM\Id
	*@ORM\GeneratedValue(strategy="AUTO")
	*/
	private $id;

	/**
	 * @ORM\Column(type="float")
	 */
	private $humidity;

	/**
	 * @ORM\Column(type="float")
	 */
	private $temperature;

	/**
     * @ORM\ManyToOne(targetEntity="Sensor")
     * @ORM\JoinColumn(name="sensor_id", referencedColumnName="id")
     */
	private $sensor;

	/**
	 * @ORM\Column(name="readed_at", type="datetimetz", nullable=false)
	 */
	private $readedAt;

	public function getId() {
	  return $this->id;
	}

	public function getHumidity() {
	    return $this->humidity;
	}

	public function setHumidity($humidity) {
	    $this->humidity = $humidity;
	    return $this;
	}

	      public function getTemperature() {
	    return $this->temperature;
	}

	public function setTemperature($temperature) {
	    $this->temperature = $temperature;
	    return $this;
	}

	      public function getSensor() {
	    return $this->sensor;
	}

	public function setSensor($sensor) {
	    $this->sensor = $sensor;
	    return $this;
	}

	      public function getReadedAt() {
	    return $this->readedAt;
	}

	public function setReadedAt($readedAt) {
	    $this->readedAt = $readedAt;
	    return $this;
	}

}
