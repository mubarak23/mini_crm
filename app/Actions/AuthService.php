<?php
namespace App\Actions;
use App\Exceptions\InvalidRequestException;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class AuthService{

    public function execute($data){

            $credentials = $request->only('email', 'password');
        if ($token = $this->guard()->attempt($credentials)) {
            return response()->json(['status' => 'success'], 200)->header('Authorization', $token);
            $user = User::where('email', $data['email'])->first();
        return response()->json(['token' => $token, 'role_id' => $user->role_id, 'name' => $user->name, 'email' => $user->email], 200);
        }
            return response()->json(['error' => 'login_error'], 401);

    }
}
