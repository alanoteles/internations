<?php

namespace App\Http\Controllers;

use App\Group;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;


class GroupController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        return Group::paginate($this->page_items);
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group){

        return response()->json($group, 200);
    }



    /**
     * Creates user.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        $cleanedNew = $this->sanitizerInput($request->all());
        $rules      = $this->getRules('group');

        $validator  = $this->validatorInput($cleanedNew, $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return response()->json(Group::create($cleanedNew), 201);

    }



    /**
     * Updates user.
     *
     * @param  Request $request
     * @param  Group $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group){


        $cleanedUpdate  = $this->sanitizerInput($request->all());
        $rules          = $this->getRules('group');

        $validator      = $this->validatorInput($cleanedUpdate, $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        try{
            $group->update($request->all());

        }catch (\Exception $e) {

            if($e instanceof \PDOException ){
                return response()->json([
                    'error' => $e->getMessage()
                ], 500);
            }
        }


        return response()->json($group, 200);
    }


    /**
     * Deletes user.
     *
     * @param  Group $group
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Group $group){

        if($group->users->count()){
            return response()->json([
                'error' => 'Group is not empty'
            ], 400);
        }
        


        try{
            $group->delete();

        }catch (\Exception $e) {

            if($e instanceof \PDOException ){
                return response()->json([
                    'error' => $e->getMessage()
                ], 500);
            }
        }

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

        $user = User::find($userId);

        if(empty(Group::find($groupId)) || empty($user)){
            return response()->json([
                'error' => 'Group/User not found'
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




    /**
     * Remove user from group.
     *
     * @param  int  $groupId
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    public function removeUser($groupId, $userId){


        $user = User::find($userId);

        if(empty(Group::find($groupId)) || empty($user)){
            return response()->json([
                'error' => 'Group/User not found'
            ], 404);
        }


        try{
            $user->groups()->detach($groupId);

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
