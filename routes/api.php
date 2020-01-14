<?php

use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:api'])->group(function (){
    Route::get('/profile', function (Request $request) {
        return new UserResource($request->user());
    });

    Route::get('logout', 'API\AuthController@logout');

    Route::apiResources(['projets' =>'API\ProjetController',
        'lists' =>'API\ListsController',
        'tasks' =>'API\TaskController']);

});

Route::post('register', 'API\AuthController@register');
Route::post('login', 'API\AuthController@login');

