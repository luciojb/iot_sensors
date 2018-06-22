<?php
namespace App\Validation;
use Validator;

class GenericValidator {
  public static function validate($input) {
    $rules = [ 'name' => 'Required|Min:3|Max:5|alpha_spaces',];
    return Validator::make($input, $rules);
  }
}
