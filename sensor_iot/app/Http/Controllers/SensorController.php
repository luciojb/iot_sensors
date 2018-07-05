<?php
namespace App\Http\Controllers;
use App\Repository\SensorRepository as repo;
use App\Validation\SensorValidator;

class SensorController extends GenericController {

  public function __construct(repo $repo) {
      parent::__construct($repo);
  }

  public function edit($id=NULL) {
      return View('admin.index')->with(['data' => $this->repo->postOfId($id)]);
  }

  public function editSensor() {
      $all = Input::all();
      $validate = SensorValidator::validate($all);
      if (!$validate->passes()) {
          return redirect()->back()->withInput()->withErrors($validate);
      }
      $Id = $this->repo->postOfId($all['id']);
      if (!is_null($Id)) {
          $this->repo->update($Id, $all);
          Session::flash('msg', 'edit success');
      } else {
          $this->repo->create($this->repo->perpare_data($all));
          Session::flash('msg', 'add success');
      }
      return redirect()->back();
  }

  public function delete() {
      $id = Input::get('id');
      $data = $this->repo->postOfId($id);
      if (!is_null($data)) {
          $this->repo->delete($data);
          Session::flash('msg', 'operation Success');
          return redirect()->back();
      } else {
          return redirect()->back()->withErrors('operationFails');
      }
}
}
