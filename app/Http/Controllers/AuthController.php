<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), $this->ruleLogin);
        if ($validator->fails()) {
            return response(["error" => "Email or password is incorrect"], 401);
        }

        $credentials = $request->only(["email", "password"]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return response()->json(["status" => "success"], 200);
        }
        return response()->json(["error" => "Email or password is incorrect"], 401);
    }

    public function show()
    {
        return view("login");
    }
}
