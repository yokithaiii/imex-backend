<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginEmailRequest;
use App\Http\Requests\Auth\LoginPhoneCodeRequest;
use App\Http\Requests\Auth\LoginPhoneRequest;
use App\Http\Requests\Auth\RegisterCodeRequest;
use App\Http\Requests\Auth\RegisterConfirmRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User\User;
use App\Models\User\UserVerifyCode;
use App\Services\AuthService;
use App\Services\EmailService;
use App\Services\SmsService;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $authService;
    protected $smsService;
    protected $emailService;
    protected $confirmationCode;

    public function __construct(
        AuthService $authService,
        SmsService $smsService,
        EmailService $emailService
    )
    {
        $this->authService = $authService;
        $this->smsService = $smsService;
        $this->emailService = $emailService;
        $this->confirmationCode = generateUserVerifyCode();
    }

    public function loginByEmail(LoginEmailRequest $request)
    {
        $validatedData = $request->validated();

        $email = $validatedData['email'];
        $password = $validatedData['password'];

        return $this->authService->authorizeEmail($email, $password);
    }

    public function loginByPhoneSendCode(LoginPhoneRequest $request)
    {
        $validatedData = $request->validated();
        $phone = normalizePhone($validatedData['phone']);

        $user = User::query()->where('phone', $phone)->first();
        if (!$user) {
            return response()->json(['error' => 'User not found with phone: '. $phone], 404);
        }

        UserVerifyCode::query()->updateOrCreate(['user_id' => $user->id], [
            'code' => $this->confirmationCode,
        ]);

        return 1111;
        return $this->smsService->sendSMS($phone, $code);
    }

    public function loginByPhoneConfirmCode(LoginPhoneCodeRequest $request)
    {
        $validatedData = $request->validated();

        $verifyUser = UserVerifyCode::query()->where('code', $validatedData['code'])->first();
        if(!$verifyUser) {
            return response()->json(['error' => 'Неверный код.'], 400);
        }

        return $this->authService->authorizePhone($verifyUser);
    }

    public function registerSendCode(RegisterCodeRequest $request)
    {
        $validatedData = $request->validated();

        $phone = null;
        $email = null;

        if (isset($validatedData['phone'])) {
            $phone = normalizePhone($validatedData['phone']);
        }

        if (isset($validatedData['email'])) {
            $email = mb_strtolower($validatedData['email']);
        }

        if ($phone) {
            $user = User::query()
                ->where('phone', $phone)
                ->where('phone_verified_at', '!=', null)
                ->exists();
            if ($user) {
                return response()->json(['error' => 'User already exists with phone: ' . $phone]);
            }

            $user = User::query()->updateOrCreate([
                'phone' => $phone
            ]);

            UserVerifyCode::query()->updateOrCreate(['user_id' => $user->id], [
                'code' => $this->confirmationCode,
            ]);

            return 1111;
            return $this->smsService->sendSMS($phone, $code);
        }

        if ($email && !$phone) {
            $user = User::query()->where('email', $email)->exists();
            if ($user) {
                return response()->json(['error' => 'User already exists with email: ' . $email]);
            }

            $user = User::query()->create([
                'email' => $email
            ]);

            UserVerifyCode::query()->updateOrCreate(['user_id' => $user->id], [
                'code' => $this->confirmationCode,
            ]);

            return 1111;
            return $this->emailService->sendEmail($email, $code);
        }

        return response()->json(['error' => 'Phone or Email is required'], 400);
    }

    public function registerConfirmCode(RegisterConfirmRequest $request)
    {
        $validatedData = $request->validated();

        $verifyUser = UserVerifyCode::query()->where('code', $validatedData['code'])->first();
        if(!$verifyUser) {
            return response()->json(['error' => 'Неверный код.'], 400);
        }

        return $this->authService->authorize($verifyUser);
    }

    public function register(RegisterRequest $request)
    {
        $validatedData = $request->validated();

        $user = $request->user();

        $user->update([
            'firstname' => $validatedData['firstname'],
            'lastname' => $validatedData['lastname'] ?? null,
            'birthdate' => $validatedData['birthdate'],
            'password' => Hash::make($validatedData['password'])
        ]);

        return response()->json(['message' => 'User created success']);
    }
}
