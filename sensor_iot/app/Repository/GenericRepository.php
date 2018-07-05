<?php
namespace App\Repository;

use Doctrine\ORM\EntityRepository;

abstract class GenericRepository {

	/**
	* @var string
	*/
	private $class = '';
	private $em;

	public function __construct($class, $em) {
		$this->class = $class;
		$this->em = $em;
	}

	public function create($entity) {
		try {
			$this->em->persist($entity);
			$this->em->flush();
			return true;
		} catch (UniqueConstraintViolationException $e) {
			return ['error' => 'unique'];
		} catch (Exception $e) {
			return ['error' => 'exception'];
		}
	}

	public function update($entity) {
		try {
			$this->em->merge($entity);
			$this->em->flush();
			return true;
		} catch (\Exception $e) {
			return ['error' => 'exception'];
		}
	}

	public function findById($id) {
		return $this->em->getRepository($this->class)->findOneById(['id' => $id]);
	}

	public function delete($entity) {
		try {
			$this->em->remove($entity);
			$this->em->flush();
			return true;
		} catch (\Exception $e) {
			return ['error' => 'exception'];
		}
	}

	public function getClass() {
		return $this->class;
	}

	public function getEntityManager() {
		return $this->em;
	}
}
