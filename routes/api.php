<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['Kiritilgan malumotlar notogri.'],
        ]);
    }

    $token = $user->createToken('MyAppToken')->accessToken;

    return response()->json(['token' => $token]);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return response()->json($request->user());
});


