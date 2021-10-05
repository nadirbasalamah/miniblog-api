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
        $user->generateToken();

        return $user->fresh();
    }

    public function login($data)
    {
        $user = User::where('email', '=', $data['email'])->firstOrFail();

        if ($user) {
            $isPasswordCorrect = Hash::check($data['password'], $user->password);
            if ($isPasswordCorrect) {
                $user->generateToken();
                return $user;
            }
        }
    }

    public function logout()
    {
        $user = Auth::user();

        if ($user) {
            $user->api_token = null;
            $user->save();
        }

        return true;
    }
}
