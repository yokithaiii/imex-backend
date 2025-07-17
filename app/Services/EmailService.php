<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

class EmailService
{
    protected $headers;
    protected $client;

    public function __construct()
    {
        $this->headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'X-API-KEY' => env('UNISENDER_GO_API_KEY'),
        ];
        $this->client = new Client([
            'base_uri' => 'https://go1.unisender.ru/ru/transactional/api/v1/'
        ]);
    }

    public function sendEmail($email, $code)
    {
        $subject = 'Код для регистрации';
        $text = 'Ваш код: ';

        $body = [
            'message' => [
                'recipients' => [
                    ['email' => $email],
                ],
                'subject' => $subject,
                'body' => [
                    "html" => "<b>$text {$code}</b>",
                ],
                'from_email' => 'info@unisender.imex.com',
            ]
        ];

        try {
            $response = $this->client->request('POST','email/send.json', array(
                'headers' => $this->headers,
                'json' => $body
            ));

            return response()->json(['message' => 'Код отправлен вам на почту.'], 200);
        } catch (BadResponseException $e) {
            return response()->json(['error' => 'Что то пошло не так, попробуйте попытку через 5 минут'], 400);
        }
    }
}
