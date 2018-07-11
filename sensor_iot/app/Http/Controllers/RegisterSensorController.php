<?php
namespace App\Http\Controllers;

use App\Entity\User;
use App\Entity\Sensor;
use App\Repository\UserRepository as userRepo;
use App\Repository\SensorRepository as sensorRepo;
use App\Http\Controllers\GenericController;
use Illuminate\Http\Request;
use App\Validation\SensorValidation;
use Session;

class RegisterSensorController extends GenericController {
	private $userRepo;
	private $sensorRepo;

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
		return view('sensor/index', $this->sensors());
	}

	protected function store(Request $request) {
		$name = $request->get('name');
        $validate = SensorValidation::validate(['name' => $name]);
        if (!$validate->passes()) {
            return redirect()->back()->withInput()->withErrors($validate);
        }
        $sensor = $this->sensorRepo->findByName($name);
        if (!is_null($sensor)) {
			error_log('Adding sensor');
			$user = \Auth::user();
			$user = $this->userRepo->findById($user['id']);

			$user->getSensors()->add($sensor);

			$return = $this->userRepo->update($user);

			if ($return['error']) {
				return redirect()->back()->withInput()->withErrors(['createError' => 'Already exists or there was an error']);
			}

            Session::flash('msg', 'added success');
        } else {
            return redirect()->back()->withInput()->withErrors(['createError' => 'No sensor with this identifier']);
        }
        return redirect()->back();
	}

	private function sensors() {
		$user = \Auth::user();
		$user = $this->userRepo->findById($user['id']);
		return ['sensors' => $user->getSensors()->toArray()];
	}

	protected function create() {
		return view('sensor/create');
	}
}
