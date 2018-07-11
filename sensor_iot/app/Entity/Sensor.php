<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
  *@ORM\Entity()
  *@ORM\Table(name="sensor")
  *@ORM\HasLifecycleCallbacks()
  */
class Sensor {

	public function __construct() {
        $this->data = new \Doctrine\Common\Collections\ArrayCollection();
    }

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

	/**
     * One Sensor has many data.
     * @ORM\OneToMany(targetEntity="Data", mappedBy="sensor", fetch="EXTRA_LAZY")
	 * @ORM\OrderBy({"readedAt" = "DESC"})
     */
	private $data;

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

	public function getData() {
		return $this->data;
	}

	public function setData($data) {
		$this->data = $data;
		return $this;
	}

}
