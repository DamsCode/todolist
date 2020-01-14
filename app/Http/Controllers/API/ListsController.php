<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Lists as ListsResource;
use App\Lists;
use App\Projet as projet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ListsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $idproj = $request->query('projet_id');
        if (Auth::check() && $idproj){

            $lists = ListsResource::collection(projet::find($idproj)->lists);
            return response()->json(['data' => $lists],200);
        }
        return response()->json(['error' =>'Need projet_id'],401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'title' => 'required',
                'projet_id' => 'required',
            ]);
        if($validator->fails()) {
            return response()->json(['error' =>  $validator->errors()],401);
        }
        $list = Projet::find($request->query('projet_id'))->lists()->create($request->all());
        return response()->json(['data' => $list],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        if (Auth::check()){
            return response()->json(['data' => Lists::find($id)],200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
            [
                'title' => 'required',
            ]);
        if($validator->fails()) {
            return response()->json(['error' =>  $validator->errors()],401);
        }
        if (Lists::find($id)->update($request->all()))
            return response()->json(['data' => "Your List has been update"],200);

        return response()->json(['error' => "Oups error"],401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $tasks = Lists::find($id)->tasks;
        if (sizeof($tasks) == 0){
            Lists::find($id)->delete();
            return response()->json(['data' => "Your List has been deleted"],200);
        }
        return response()->json(['error' => "You need to delete all his tasks before deleting"],401);
    }
}
