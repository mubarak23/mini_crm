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
        try {
            $payload = [
                'iss' => $data['email'],
                'aud' => $data['email'],
                'iat' => time(),
                'nbf' => time(),
                'exp' =>  time() + 90 * 30
            ];
            if (! $token = JWTAuth::claims($payload)->attempt($data)) {
                return response()->json(['message' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['message' => 'could_not_create_token'], 500);
        }
        $user = User::where('email', $data['email'])->first();
        return response()->json(['token' => $token, 'user_id' => $user->id, 'name' => $user->name, 'role_id' => $user->role_id], 200);
    }
}
