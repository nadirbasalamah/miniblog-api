<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Exception;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        $data = $request->only([
            'name',
            'email',
            'password',
        ]);

        $result = ['status' => 201];

        try {
            $result['data'] = $this->authService->register($data);
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage(),
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function login(Request $request)
    {
        $data = $request->only([
            'email',
            'password'
        ]);

        $result = ['status' => 200];

        try {
            $result['data'] = $this->authService->login($data);
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage(),
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function logout(Request $request)
    {
        $this->authService->logout();
        return response()->json(['status' => 200, 'message' => 'Logout success'], 200);
    }
}
