<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json(["message" => "Logout successfully"], 200);
    }

    public function getSelf(Request $request)
    {
        return Auth::user();
    }
}
