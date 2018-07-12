<?php
namespace App\Http\Controllers;

use App\Validation\SensorValidator;
use Session;
use App\Entity\User;
use App\Entity\Sensor;
use App\Repository\UserRepository as userRepo;
use App\Repository\SensorRepository as sensorRepo;
use App\Http\Controllers\GenericController;

class SensorController extends GenericController {
	private $sensorRepo;
	private $userRepo;

	public function __construct(sensorRepo $repo, userRepo $userRepo) {
		$this->sensorRepo = $repo;
		$this->userRepo = $userRepo;
		$this->middleware('auth');
	}

	public function destroy($id=NULL) {
		if ($id==null) {
			return redirect()->back();
		}
		$user = \Auth::user();
		$user = $this->userRepo->findById($user['id']);
		foreach($user->getSensors() as $s) {
			if ($s->getId() == $id) {
				$user->getSensors()->removeElement($s);
			}
		}
		$result = $this->userRepo->update($user);
		if (empty($result['error'])) {
			Session::flash('msg', 'removed success');
		} else {
			Session::flash('error', 'not removed');
		}
		return redirect('sensors');

	}

	public function show($id = NULL) {
		if($id == null) {
			return redirect()->back();
		}

		$sensor = $this->sensorRepo->findById($id);
		if (empty($sensor)) {
			return redirect()->back();
		}

		$data = $sensor->getData()->slice(0, 20);
		$jsonarr = [];
		foreach ($data as $d) {
			// $jsonarr['categories'][] = $d->getReadedAt()->getTimestamp()*1000;
			$jsonarr['categories'][] = $d->getReadedAt()->format('Y-m-d H:i');
			$jsonarr['temperatures'][] = $d->getTemperature();
			$jsonarr['humidities'][] = $d->getHumidity();
		}
		return view('sensor/show', ['sensor' => $sensor, 'data' => $jsonarr]);
	}

	public function remove($id=NULL) {
		if($id == null) {
			return redirect()->back();
		}
		$sensor = $this->sensorRepo->findById($id);
		if (empty($sensor)) {
			return redirect()->back();
		}
		return view('sensor/confirm', ['id' => $sensor->getId(), 'name' => $sensor->getName()]);
	}
}
