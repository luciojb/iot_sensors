<?php
namespace App\Repository;

use GenericRepository;

class SensorRepository extends GenericRepository {

  function __construct() {
		parent::__construct("App\Entity\Sensor");
	}
}
