<?php
namespace App\Repository;

use Doctrine\ORM\EntityManager as em;
use App\Repository\GenericRepository;

class SensorRepository extends GenericRepository {

	function __construct(em $em) {
		parent::__construct("App\Entity\Sensor", $em);
	}

	public function findById($id) {
		return $this->em->getRepository($this->class)->findOneById(['id' => $id]);
	}

	public function findByName($name) {
		return $this->em->getRepository($this->class)->findOneBy(['name' => $name]);
	}
}
