<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;

class GroupController extends Controller
{
    public function index(){

        return Group::all();
    }


    public function show($group){

        return $group;
    }


    public function store(Request $request){

        $group = Group::create($request->all());

        return response()->json($group, 201);
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
