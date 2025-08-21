<?php

namespace App\Services;

use App\Models\Tender\Tender;

class TenderService
{
    public function createTender($input)
    {
        $tender = Tender::query()->create($input);

        return response()->json([
            'message' => 'Tender created successfully.',
            'data' => $tender
        ], 201);
    }
}
