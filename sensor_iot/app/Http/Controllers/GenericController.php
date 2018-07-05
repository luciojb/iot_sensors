<?php
namespace App\Http\Controllers;

class GenericController extends Controller {
  private $repo;

  public function __construct($repo) {
      $this->repo = $repo;
  }
}
