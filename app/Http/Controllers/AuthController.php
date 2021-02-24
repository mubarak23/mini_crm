<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Actions\UserAccount;
use App\Actions\AuthService;
use App\User;
use App\Actions\GenerateJWTTokenAction;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    //refactor regiister to send back existing email
    public function register(Request $request, UserAccount $UserAccount){
        $validation = Validator::make($request->all(), [
            'name' => 'required',
             'email' => 'required|email|unique:users',
            'password' => 'required|min:3'
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


    public function auth_login(Request $request){
        $credentials = $request->only('email', 'password');
        $data = $request->all();
        if ($token = $this->guard()->attempt($credentials)) {
            $user = User::where('email', $data['email'])->first();
            return response()->json(['status' => 'success', 'token' => $token,
            'user_id' => $user->id, 'name' => $user->name,
        'role_id' => $user->role_id], 200)->header('Authorization', $token);
        }
        return response()->json(['error' => 'login_error'], 401);
    }

    public function refresh(){
        if ($token = $this->guard()->refresh()) {
            return response()
                ->json(['status' => 'successs'], 200)
                ->header('Authorization', $token);
        }
        return response()->json(['error' => 'refresh_token_error'], 401);

    }

    public function logout(){
         $this->guard()->logout();
        return response()->json([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }

    private function guard()
    {
        return Auth::guard();
    }
}
