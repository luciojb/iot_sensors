<?php
namespace App\Validation;
use Validator;

class SensorValidation {

	public static function validate($input) {
	  $rules = [ 'name' => 'Required|Min:3|Max:5',];
	  return Validator::make($input, $rules);
	}

}
