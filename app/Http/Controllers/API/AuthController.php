<?php
namespace App\Http\Controllers\Api;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use mysql_xdevapi\Exception;

class AuthController extends BaseController
{
    public $successStatus = 200;

    public function register(Request $request) {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'c_password' => 'required|same:password',
            ]);
        if($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(),401);
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        try {
            User::create($input);
            return $this->sendResponse(['success'=> 'User register successfully.'],200);
        }catch (QueryException $e){
            return $this->sendError('Email Error', ["This email is already used"],401);
        }

    }


    public function login(Request $request){
        $validator = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required',
            ]);
        if($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(),200);
        }

        $credentials = $request->only('email', 'password');
        if(Auth::attempt($credentials)){
            $user = Auth::user();
            $token = Str::random(80);
            $user->forceFill([
                'api_token' => hash('sha256', $token),
            ])->save();
            $success['user'] =  $user;
            return response()->json(['success' => $success], $this-> successStatus);
        } else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    public function logout(Request $request){
        if (Auth::check()) {
            $user = Auth::user();
            $token = Str::random(80);
            $user->forceFill([
                'api_token' => hash('sha256', $token),
            ])->save();
            return response()->json(['success' =>'User has been logout'],$this-> successStatus);
        }
        return response()->json(['error' =>'Oups probleme'],401);
    }
}
