<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::paginate($this->page_items);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(array $data)
    {
        return User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'admin'     => !empty($data['admin']) ? $data['admin'] : false,
            'password'  => bcrypt($data['password']),
        ]);
    }





    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json($user, 200);
    }





    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $cleanedUpdate  = $this->sanitizerInput($request->all());
        $rules          = $this->getRules('user');

        $validator      = $this->validatorInput($cleanedUpdate, $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }




        try{
            $user->update($request->all());

        }catch (\Exception $e) {

            if($e instanceof \PDOException ){
                return response()->json([
                    'error' => $e->getMessage()
                ], 500);
            }
        }


        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(User $user)
    {


        try{
            $user->delete();

        }catch (\Exception $e) {

            if($e instanceof \PDOException ){
                return response()->json([
                    'error' => $e->getMessage()
                ], 500);
            }
        }


        return response()->json(null, 204);
    }
}
