<?php

namespace App\Http\Controllers\Auth;

use App\Entity\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Repository\UserRepository as repo;
use Illuminate\Http\Request;
use Session;

class RegisterController extends Controller {
	private $repo;
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

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
    public function __construct(repo $repo, array $attributes = []) {
		$this->repo = $repo;
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

	protected function register(Request $request) {
	        /** @var User $user */
			// $data = ['name'=>$request->get('name'), 'email'=>$request->get('email'), 'password'=>$request->get('password') ];
			$validateData = $request->validate([
	            'name' => 'required|string|max:255|unique:users',
	            'email' => 'required|string|email|max:255|unique:users',
	            'password' => 'required|string|min:6|confirmed',
	        ]);
	        try {
				$date = new \DateTime('', new \DateTimeZone('America/Sao_Paulo'));
				$date->format("Y-m-d H:i:s");
				$user = new User();
				$user
					->setName($validateData['name'])
					->setEmail($validateData['email'])
					->setCreatedAt($date)
					->setUpdatedAt($date)
					->setPassword(Hash::make($validateData['password']));
				$return = $this->repo->create($user);
				if ($return['error']) {
					return redirect()->back()->withInput()->withErrors(['message' => 'Already exists or there was an error']);
				}
	        } catch (\Exception $exception) {
				error_log($exception->getMessage());
	            return redirect()->back()->withInput()->withErrors(['message' => 'Already exists or there was an error']);
	        }
			Session::flash('message', 'Successfully created');
	        return redirect()->back();
	    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Entity\User
     */
    // protected function create(array $data) {
	// 	$date = new \DateTime('', new \DateTimeZone('America/Sao_Paulo'));
	// 	$date->format("Y-m-d H:i:s");
	// 	// $validate = $this->validator($data);
	// 	// if ($validate->passes()) {
	// 	// 	$user = new User();
	// 	//
	// 	// 	$user
	// 	// 		->setName($data['name'])
	// 	// 		->setEmail($data['email'])
	// 	// 		->setCreatedAt($date)
	// 	// 		->setUpdatedAt($date)
	// 	// 		->setPassword(Hash::make($data['password']));
	// 	// 	$return = $this->repo->create($user);
	// 	// 	if ($return['error']) {
	// 	// 		return redirect()->back()->withInput()->withErrors(['createError' => 'Already exists or there was an error']);
	// 	// 	}
	// 	//
	// 	// } else {
	// 	// 	return redirect()->back()->withInput()->withErrors($validate);
	// 	// }
	//
    //     return User::create([
    //         'name' => $data['name'],
    //         'email' => $data['email'],
	// 		'created_at' =>  $date,
	// 		'updated_at' =>  $date,
    //         'password' => Hash::make($data['password']),
    //     ]);
    // }
}
