<?php

namespace App\Services;

class SmsService
{
    public function sendSMS($phone, $code)
    {
        $url = 'https://lcab.smsint.ru/json/v1.0/sms/send/text';

        $headers = [
            'Content-Type: application/json',
            'X-Token: ' . env('SMSINT_API_KEY'),
        ];

        $body = [
            'messages' => [
                [
                    'recipient' => $phone,
                    'recipientType' => 'recipient',
                    'text' => 'Ваш код для авторизации в Bodyline: ' . $code, //Если будете менять, поменяйте шаблон модерации на smsint тоже
                ],
            ],
            'validate' => false,
            'tags' => [
                'SITE'
            ],
            'timezone' => 'Asia/Yakutsk',
            'channel' => 0
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        $responseArray = json_decode($response, true);

        if (json_last_error() != JSON_ERROR_NONE) {
            return response()->json(['error' => 'Error response format'], $info['http_code']);
        }

        if ($info['http_code'] != 200) {
            return response()->json(['error' => $responseArray['error']['descr']], $responseArray['error']['code']);
        }

        return response()->json(['message' => 'Код отправлен на указанный номер.']);
    }
}
