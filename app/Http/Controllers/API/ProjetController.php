<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Projet as ProjetResource;
use App\Projet as Projet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ProjetController extends Controller
{
    protected $projets;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        if (Auth::check()){
            $user = Auth::user();
            $projets = ProjetResource::collection($user->projets);
            return response()->json(['data' => $projets],200);
        }
        return response()->json(['error' =>'no Authorize'],401);
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
                'description' => 'required',
            ]);
        if($validator->fails()) {
            return response()->json(['error' =>  $validator->errors()],401);
        }
        $user = Auth::user();
        $input = $request->all();
        $projet = $user->projets()->create($input);
        return response()->json(['data' => $projet],200);

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
            return response()->json(['data' => Projet::find($id)],200);
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
                'description' => 'required',
            ]);
        if($validator->fails()) {
            return response()->json(['error' =>  $validator->errors()],401);
        }
        if (Projet::find($id)->update($request->all()))
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
        $tasks = Projet::find($id)->lists;
        if (sizeof($tasks) == 0){
            Projet::find($id)->delete();
            return response()->json(['data' => "Your List has been deleted"],200);
        }
        return response()->json(['error' => "You need to delete all his tasks before deleting"],401);
    }
}
