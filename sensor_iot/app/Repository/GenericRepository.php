<?php
namespace App\Repository;

use Doctrine\ORM\EntityManager as em;

class GenericRepository {

  /**
   * @var string
   */
  private $class = '';
  private $em;

  public function __construct($class, em $em) {
      $this->class = $class;
	  $this->em = $em;
  }


  public function create($entity) {
    try {
      $this->em->persist($entity);
      $this->em->flush();
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
		} catch (\Exception $e) {
			return ['error' => 'exception'];
		}
  }

  public function findById($id) {
      return $this->em->getRepository($this->class)->findOneBy(['id' => $id]);
  }

  public function delete($entity) {
    try {
      $this->em->remove($entity);
      $this->em->flush();
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
