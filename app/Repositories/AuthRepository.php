<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function register($data)
    {
        $user = new $this->user;

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);

        $user->save();

        $token = $user->createToken("myapptoken")->plainTextToken;

        $result = [
            "user" => $user->fresh(),
            "token" => $token
        ];

        return $result;
    }

    public function login($data)
    {
        $user = User::where('email', '=', $data['email'])->firstOrFail();

        if ($user) {
            $isPasswordCorrect = Hash::check($data['password'], $user->password);
            if ($isPasswordCorrect) {

                $token = $user->createToken("myapptoken")->plainTextToken;
                $result = [
                    "user" => $user,
                    "token" => $token,
                ];

                return $result;
            }
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return true;
    }
}
