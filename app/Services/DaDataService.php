<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DaDataService
{
    protected string $baseUrl = 'https://suggestions.dadata.ru/suggestions/api/4_1/rs';
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = env('DADATA_API_KEY');
    }

    public function findCompanyByInn($inn, $type)
    {
        $url = $this->baseUrl . '/findById/party';

        $response = Http::withHeaders([
            'Authorization' => 'Token ' . $this->apiKey,
            'Content-Type'  => 'application/json',
        ])->post($url, [
            'query' => $inn,
            'count' => 1,
            'branch_type' => 'MAIN',
            'type' => mb_strtoupper($type),
        ]);

        if ($response->successful()) {
            $data = $response->json();

            if (!empty($data['suggestions'])) {
                return $data['suggestions'][0];
            }
        }

        return null;
    }
}
