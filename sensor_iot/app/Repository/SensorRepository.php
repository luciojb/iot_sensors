<?php
namespace App\Repository;

use Doctrine\ORM\EntityManager as em;
use App\Repository\GenericRepository;

class SensorRepository extends GenericRepository {

	function __construct(em $em) {
		parent::__construct("App\Entity\Sensor", $em);
	}

	public function findByName($name) {
		return $this->getEntityManager()->getRepository($this->getClass())->findOneBy(['name' => $name]);
	}
}
