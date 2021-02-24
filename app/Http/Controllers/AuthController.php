<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Actions\UserAccount;
use App\Actions\AuthService;
use App\User;
use App\Actions\GenerateJWTTokenAction;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    public function register(Request $request, UserAccount $UserAccount){
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);
        if($validation->fails()){
            return response()->json($validation->errors(), 401);
         }
         $data = $request->all();

         $data['password'] = Hash::make($data['password']);
         $data['role_id'] = '2';
         $new_account = $UserAccount->execute($data);
         if($new_account){
             return response()->json(['message' => 'Employee Account Created Successfully'], 201);
         }
         return response()->json(['message' => 'Employee Account Creation Failed, Try Again'], 400);

    }

    public function login(Request $request, AuthService $AuthService){
        $validation = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);
        if($validation->fails()){
            return response()->json($validation->errors(), 401);
         }

         $data = $request->all();
         $authlogin = $AuthService->execute($data);
         return $authlogin;
    }

    public function refresh(){

    }

    public function logout(){

    }

    public function user(){

    }
}
