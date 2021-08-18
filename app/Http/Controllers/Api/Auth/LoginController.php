<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class LoginController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  LoginRequest  $request
     * @return JsonResponse|object
     */
    public function login(LoginRequest $request)
    {
        // Check user in database
        $user = User::where('email', '=', $request->email)->first();
        if (!$user) {
            return response()
                ->json(['errors' => [ 1 => 'User not found']])
                ->setStatusCode(422);
        }

        // Check credentials
        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()
                ->json(['errors' => [2 =>'Credentials not match']])
                ->setStatusCode(422);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'user' => new UserResource($user),
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * @param  Request  $request
     * @return string[]
     */
    public function logout(Request $request): array
    {
        Auth::logout();
        Auth::user()->tokens()->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Tokens Revoked']);
    }

    /**
     * Forgot password email form
     */
    public function forgot(Request $request): JsonResponse
    {
        $credentials = request()->validate(['email' => 'required|email']);
        if (!$credentials) {
            return response()
                ->json(['errors' => [2 =>'Credentials not match']])
                ->setStatusCode(422);
        }
        Password::sendResetLink($credentials);

        return response()->json(["message" => 'Reset password link sent on your email.']);
    }

    /**
     * Reset password form
     */
    public function reset(): JsonResponse
    {
        $credentials = request()->validate([
            'token' => 'required|string',
            'password' => 'required|string|confirmed'
        ]);

        $reset_password_status = Password::reset($credentials, function ($user, $password) {
            $user->password = $password;
            $user->save();
        });

        if ($reset_password_status == Password::INVALID_TOKEN) {
            return response()->json(["msg" => "Invalid token provided"], 400);
        }

        return response()->json(["msg" => "Password has been successfully changed"]);
    }
}
