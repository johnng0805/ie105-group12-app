<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), $this->ruleLogin);
        if ($validator->fails()) {
            return response()->json(["error" => "Email or password is incorrect"], 401);
        }

        $credentials = $request->only(["email", "password"]);
        if (!Auth::attempt($credentials)) {
            return response()->json(["error" => "Email or password is incorrect"], 401);
        }

        $accessToken = $request->user()->createToken("authToken", ["user"])->accessToken;

        return response()->json(["user" => Auth::user(), "access_token" => $accessToken], 200);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), $this->ruleRegister);
        if ($validator->fails()) {
            return response()->json(["error" => $validator->errors()], 400);
        }

        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = password_hash($request->password, PASSWORD_BCRYPT);

        $user->save();

        return response()->json(["status" => "success"], 200);
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            $request->user()->token()->revoke();
            return response()->json(["status" => "Logout success"], 200);
        }
    }
}
