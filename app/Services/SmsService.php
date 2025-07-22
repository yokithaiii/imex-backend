<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class SmsService
{
    public function sendSMS($phone, $code)
    {
        $login = env('REDSMS_LOGIN');
        $apiKey = env('REDSMS_API_KEY');
        $sender = env('REDSMS_SENDER');

        $ts = 'ts-value-' . time();
        $secret = md5($ts . $apiKey);
        $text = 'Код: ' . $code;

        $payload = [
            'route' => 'sms',
            'from' => $sender,
            'to' => $phone,
            'text' => $text,
        ];

        $headers = [
            'login: ' . $login,
            'ts: ' . $ts,
            'secret: ' . $secret,
            'Content-type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://cp.redsms.ru/api/message');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $responseData = json_decode($response, true);

        if ($httpCode === 200) {
            return response()->json(['message' => 'На ваш номер телефона отправлен код'], 200);
        }

        Log::error('RedSMS sending failed', [
            'http_code' => $httpCode,
            'response' => $responseData,
        ]);

        return false;
    }
}
