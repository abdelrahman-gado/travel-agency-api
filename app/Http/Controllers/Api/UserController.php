<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{


    /**
     * Store a newly created user in database.
     */
    public function store(Request $request)
    {
        try {

            $validated = $request->validate([
                'email' => 'required|email|unique:users',
                'password' => 'required'
            ]);

            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            if ($request->roles) {
                $user->roles()->attach($request->roles);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'email' => $user->email,
                'access_token' => $token,
                'token_type' => 'Bearer'
            ]);

        } catch (ValidationException $e) {
            return response()->json(["message" => $e->getMessage()], 422);
        }
    }

}
