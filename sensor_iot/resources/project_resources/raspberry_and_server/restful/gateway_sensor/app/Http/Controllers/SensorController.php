<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SensorController extends Controller {
  public function showSensorById($id) {
    //DB::insert('INSERT INTO sensor (id,identifier, temperature, humidity) VALUES (1,"S1",27,10.2)');
    $data = DB::select('select * from sensor where identifier = ?', [$id]);
    header('Content-Type: application/json; charset=utf-8');
    return json_encode($data);
  }

  public function showAllSensors() {
    $all = DB::select('select * from sensor');
    header('Content-Type: application/json; charset=utf-8');
    return json_encode($all);
  }
}

