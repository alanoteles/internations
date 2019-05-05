<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;


class GroupController extends Controller
{
    public function index(){

        return Group::all();
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
//    protected function validator(array $data)
//    {
//        return Validator::make($data, [
//            'name'      => 'required|string|max:255'
//        ]);
//    }

    public function show($group){

        return $group;
    }


    public function store(Request $request){

        $cleanedNew = $this->sanitizerInput($request->all());
        $rules      = $this->getRules('group');

        $validator  = $this->validatorInput($cleanedNew, $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return response()->json(Group::create($cleanedNew), 201);

    }


    public function update(Request $request, $group){

        $group->update($request->all());

        return response()->json($group, 200);
    }


    public function delete($group){

        $group->delete();

        return response()->json(null, 204);
    }
}
