<?php
namespace App\Repository;
use Doctrine\ORM\EntityManager as em;

class UserRepository extends GenericRepository {

  	function __construct(em $em) {
		parent::__construct("App\Entity\User", $em);
	}

	public function findLastId() {
		$qb = $this->getEntityManager()->createQueryBuilder();
		$qb->select('MAX(u.id)')->from($this->getClass(), 'u');
		try {
			return $qb->getQuery()->getSingleResult();
		} catch (Exception $e) {
			return false;
		}
	}

	
}
