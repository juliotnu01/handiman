<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ExternalLoginController extends Controller
{
    public function verify(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
            $user = User::where('email', $request->email)->with(['basicInformation'])->first();
            if ($user && Hash::check($request->password, $user->password)) {
                return response()->json(["valid" => true, "user" => $user]);
            }
            return response(400)->json(["valid" => false, "user" => null]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
