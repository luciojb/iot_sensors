<?php
namespace App\Http\Controllers;
use App\Validation\GenericValidator;

class GenericController extends Controller {
  private $repo;

  public function __construct($repo) {
      $this->repo = $repo;
  }
}
