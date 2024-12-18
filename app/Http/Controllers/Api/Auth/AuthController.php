<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;


class AuthController extends Controller
{
    public function register(Request $request){
        $Validator = Validator::make($request->all(),[
            "name"=>"required|string|max:255",
            "email"=> "required|email|max:255|string|unique:users,email",
            "password"=> ["required" , "min:8" ,"confirmed", Password::defaults()]
        ]);

        if($Validator->fails()){
            return response()->json([
                "message"=>"Can't Register .",
                "status"=>403,
                "data"=>$Validator->errors(),

            ],403);
        }
        $password = Hash::make($request->password);
        
        $user = User::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=>$password,
        ]);
        // $token = $user->createToken("API TOKEN OF ". $user->name)->plainTextToken;

        return response()->json([
            "message"=>"Registration Done Successfully .",
            "status"=>200,
            "data"=>$user,
            // "token"=>$token
        ],200);
    }


    public function login(Request $request){
        
        
        $Validator = Validator::make($request->all(),[
            "email"=> "required|email|string",
            "password"=> "required|min:8"
        ]);

        if($Validator->fails()){
            return response()->json([
                "message"=>"Can't Login .",
                "status"=>403,
                "data"=>$Validator->errors(),
            ],403);
        }
        $user = User::where("email","=",$request->email)->first();
        $password = Hash::check($request->password,$user->password);

        if($user && $password){
        if($user->tokens()->count()>0) return response()->json(["message"=>"already logged in ."],300);
            return response()->json([
                "message"=>"Login Done Successfully .",
                "status"=>200,
                "data"=>$user,
                "token"=>$user->createToken("API TOKEN OF ". $user->name)->plainTextToken
            ],200);
        }

        return response()->json([
            "message"=>"Credentials not correct .",
            "status"=>403,
            "data"=>NULL
        ],403);


    }





    public function logout(Request $request){
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthenticated or Invalid Token'], 401);
        }
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Successfully logged out'],200);
        
        
    }
}
