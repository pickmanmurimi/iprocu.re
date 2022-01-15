<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    //
    public function register(RegistrationRequest $request)
    {
        try {
            User::create([
                'firstName' => $request->first_name,
                'lastName' => $request->last_name,
                'phoneNumber' => $request->phone_number,
                'email' => $request->email,
                'password' => Hash::make($request->password), // Uses bcrypt as the default driver
            ]);

            return response()->json([ 'status' => 'success', 'message' => 'User created'], 201);
        } catch ( \Exception $e)
        {
            return response()->json([ 'status' => 'error', 'message' => $e->getMessage()], 500);
        }

    }
}
