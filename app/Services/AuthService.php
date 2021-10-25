<?php

namespace App\Services;

use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class AuthService
{

    protected $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register($data)
    {
        $validation = $this->validateRequest($data, true);

        if ($validation->fails()) {
            throw new InvalidArgumentException($validation->errors()->first());
        }

        $result = $this->authRepository->register($data);

        return $result;
    }

    public function login($data)
    {
        $validation = $this->validateRequest($data);

        if ($validation->fails()) {
            throw new InvalidArgumentException($validation->errors()->first());
        }

        $result = $this->authRepository->login($data);

        return $result;
    }

    public function logout()
    {
        return $this->authRepository->logout();
    }

    public function validateRequest($data, $register = false)
    {
        $rules = $register ? [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ] : [
            'email' => 'required',
            'password' => 'required'
        ];

        $validator = Validator::make($data, $rules);

        return $validator;
    }
}
