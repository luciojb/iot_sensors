<?php
namespace App\Repository;

use GenericRepository;

class SensorDataRepository extends GenericRepository {

	function __construct(em $em) {
		parent::__construct("App\Entity\Data", $em);
	}
}
