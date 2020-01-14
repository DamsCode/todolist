<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Task as TasksResource;
use App\Lists;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $idlist = $request->query('lists_id');
        if (Auth::check() && $idlist){
            $tasks = TasksResource::collection(lists::find($idlist)->tasks);
            return response()->json(['data' => $tasks],200);
        }
        return response()->json(['error' =>'Need lists_id'],401);
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
                'task' => 'required',
                'lists_id' => 'required',
            ]);
        if($validator->fails()) {
            return response()->json(['error' =>  $validator->errors()],401);
        }
        $list = Lists::find($request->query('lists_id'))->tasks()->create($request->all());
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
            return response()->json(['data' => Task::find($id)],200);
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
                'task' => 'required',
                'isDone' => 'required',
            ]);
        if($validator->fails()) {
            return response()->json(['error' =>  $validator->errors()],401);
        }
        if (Task::find($id)->update($request->all()))
            return response()->json(['data' => "Your Task has been update"],200);

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
        Task::find($id)->delete();
        return response()->json(['data' => "Your Task has been deleted"],200);
    }
}
