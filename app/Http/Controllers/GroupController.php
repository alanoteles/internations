<?php

namespace App\Http\Controllers;

use App\Group;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;


class GroupController extends Controller
{
    public function index(){

        return Group::all();
    }



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




    /**
     * Add user to a group.
     *
     * @param  int  $groupId
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    public function addUser($groupId, $userId){

        $group = Group::find($groupId);

        if(empty($group)){
            return response()->json([
                'error' => 'Group not found'
            ], 404);
        }



        $user = User::find($userId);

        if(empty($user)){
            return response()->json([
                'error' => 'User not found'
            ], 404);
        }



        if(!empty($user->groups->contains($groupId))){
            return response()->json([
                'error' => 'This User is already on this group.'
            ], 400);
        }


        try{
            $user->groups()->attach($groupId);

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
