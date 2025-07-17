<?php

namespace App\Services;


use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function authorize($verifyUser)
    {
        $user = $verifyUser->user;

        if ($user->email && $user->email_verified_at === null) {
            $this->verifyPhone($user);
        }

        if ($user->phone && $user->phone_verified_at === null) {
            $this->verifyEmail($user);
        }

        $user->save();
        $token = $this->issueToken($user);
        $this->deleteCode($verifyUser);

        return response()->json([
            'token_type' => 'Bearer',
            'access_token' => $token
        ], 200);
    }

    public function authorizeEmail($email, $password)
    {
        $user = User::query()->where('email', $email)->first();

        if (!$user || !$user->password || !Hash::check($password, $user->password)) {
            return response()->json(['error' => 'Email или пароль неверный.'], 400);
        }

        $token = $this->issueToken($user);

        return response()->json([
            'token_type' => 'Bearer',
            'access_token' => $token,
        ], 200);
    }

    public function authorizePhone($verifyUser)
    {
        $user = $verifyUser->user;

        if ($user->phone && $user->phone_verified_at === null) {
            $this->verifyEmail($user);
        }

        $user->save();

        $token = $this->issueToken($user);

        $this->deleteCode($verifyUser);

        return response()->json([
            'token_type' => 'Bearer',
            'access_token' => $token
        ], 200);
    }

    private function verifyPhone($user)
    {
        $user->phone_verified_at = Carbon::now();
    }

    private function verifyEmail($user)
    {
        $user->email_verified_at = Carbon::now();
    }

    private function deleteCode($verifyUser)
    {
        $verifyUser->delete();
    }

    private function issueToken($user)
    {
        return $user->createToken('auth_token')->plainTextToken;
    }

}
