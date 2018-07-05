<?php
namespace App\Http\Controllers;

use App\Entity\User;
use App\Entity\Sensor;
use App\Repository\UserRepository as userRepo;
use App\Repository\SensorRepository as sensorRepo;
use App\Http\Controllers\GenericController;
use Illuminate\Http\Request;

class RegisterSensorController extends GenericController {
	private $userRepo;
	private $sensorRepo;

	/**
	* Where to redirect users after registration.
	*
	* @var string
	*/
	protected $redirectTo = '/sensors';

	/**
	* Create a new controller instance.
	*
	* @return void
	*/
	public function __construct(userRepo $userRepo, sensorRepo $sensorRepo) {
		$this->userRepo = $userRepo;
		$this->sensorRepo = $sensorRepo;
		$this->middleware('auth');
	}

	private function validateData($data) {

	}

	/**
	* Show the application dashboard.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index() {
		return view('sensor/index');
	}

	protected function store(Request $request) {
		$name = $request->get('name');
        $validate = SensorValidator::validate($all);
        if (!$validate->passes()) {
            return redirect()->back()->withInput()->withErrors($validate);
        }
        $sensor = $this->sensorRepo->findByName($name);
        if (!is_null($sensor)) {

            $this->repo->update($Id, $all);
            Session::flash('msg', 'edit success');
        } else {
            Session::flash('msg', 'no sensor');
        }
        return redirect()->back();
	}

	protected function create() {
		return view('sensor/create');
	}
}
