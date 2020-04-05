<?php
// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use App\Http\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Validator;

class AuthController extends Controller
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * AuthController constructor.
     * @param UserService $userService
     */
    public function __construct(
        UserService $userService
    )
    {
        $this->userService = $userService;
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'fails',
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()->toArray(),
            ]);
        }

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status' => 'fails',
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = $request->user();

        $scopeData = [];
        foreach ($user->roles as $role) {
            switch ($role->name) {
                case 'Admin':
                    $scopeData[] ='*';
                    $user->is_admin = true;
                    break;
                default:
                    foreach ($role->permissions as $permission) {
                        $scopeData[] = $permission->name;
                    }
                    $user->is_admin = false;
                    break;
            }
        }
        $tokenResult = $user->createToken('Personal Access Token', $scopeData);
        $token = $tokenResult->token;

        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        $token->save();

        return response()->json([
            'status' => 'success',
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            'user_data' => $user
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'status' => 'success',
        ]);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
