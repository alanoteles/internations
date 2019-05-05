<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }




    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $cleanedNew = $this->sanitizerInput($request->all());
        $rules      = $this->getRules('user');

        $validator  = $this->validatorInput($cleanedNew, $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        event(new Registered($user = $this->create($cleanedNew)));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        return User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'admin'     => !empty($data['admin']) ? $data['admin'] : false,
            'password'  => bcrypt($data['password']),
        ]);
    }


    protected function registered(Request $request, $user){

        $user->createToken();

        return response()->json(['data' => $user->toArray()], 201);
    }
}
