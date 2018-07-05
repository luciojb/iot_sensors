<?php

namespace App\Entity;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Doctrine\ORM\Mapping as ORM;

/**
  *@ORM\Entity()
  *@ORM\Table(name="users")
  *@ORM\HasLifecycleCallbacks()
  */
class User extends Authenticatable {

	public function __construct() {
        $this->sensors = new \Doctrine\Common\Collections\ArrayCollection();
    }

	/**
	*@var integer $id
	*@ORM\Column(name="id", type="integer", unique=true, nullable=true)
	*@ORM\Id
	*@ORM\GeneratedValue(strategy="AUTO")
	*/
	private $id;

	/**
	  *@ORM\Column(name="name", type="string", unique=true, nullable=false)
	  */
	private $name;

	/**
	  *@ORM\Column(name="email", type="string", unique=true, nullable=false)
	  */
	private $email;

	/**
	  *@ORM\Column(name="password", type="string", nullable=false)
	  */
	private $password;

	/**
	  *@ORM\Column(name="created_at", type="datetimetz", nullable=true)
	  */
	private $createdAt;

	/**
	  *@ORM\Column(name="updated_at", type="datetimetz", nullable=true)
	  */
	private $updatedAt;

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'created_at', 'updated_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
		'password', 'remember_token',
    ];

	/**
	* Many Users have Many Sensors.
	* @ORM\ManyToMany(targetEntity="App\Entity\Sensor")
	* @ORM\JoinTable(name="users_has_sensor",
	*      joinColumns={@ORM\JoinColumn(name="users_id", referencedColumnName="id")},
	*      inverseJoinColumns={@ORM\JoinColumn(name="sensor_id", referencedColumnName="id")}
	*      )
	*/
	private $sensors;

	public function getId() {
		return $this->id;
	}

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
		return $this;
    }

	public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

	public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
        return $this;
    }

	public function getSensors() {
	    return $this->sensors;
	}

	public function setSensors($sensors) {
	    $this->sensors = $sensors;
	    return $this;
	}

}
