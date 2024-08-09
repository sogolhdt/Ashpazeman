<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\ModelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Response;

class AuthController extends ModelController
{

    public function __construct(Request $request, User $model)
    {
        parent::__construct($request, $model);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return $this->failedResponse(__('authentication.incorrent_credentials'),Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();
        return $this->tokenResponse($token, $user);
    }

    public function register()
    {

        $this->request->validate([
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'email' => 'required|string|email|max:50|unique:users',
            'password' => 'required|string|min:6',
        ]);
        $this->requestFillable['password'] = Hash::make($this->request->input('password'));
        $user = $this->model->saveModel($this->requestFillable);
        $token = Auth::login($user);
        return $this->tokenResponse($token);
    }

    public function logout()
    {
        Auth::logout();
        return $this->successResponse('',__('authentication.success_logout'));
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
