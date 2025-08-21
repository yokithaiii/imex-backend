<?php

namespace App\Services;

use App\Models\Tender\Tender;
use App\Models\Tender\TenderFile;
use Illuminate\Support\Facades\DB;

class TenderService
{
    public function createTender($input)
    {
        try {
            $tender = DB::transaction(function () use ($input) {
                $tender = Tender::query()->create($input);

                if (!empty($input['files'])) {
                    foreach ($input['files'] as $file) {
                        TenderFile::query()->create([
                            'tender_id' => $tender->id,
                            'url' => $file['url'],
                            'type' => $file['type'],
                        ]);
                    }
                }

                return $tender;
            });

            return response()->json([
                'message' => 'Tender created successfully.',
                'data' => $tender->load('files') // можно сразу вернуть файлы
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Ошибка при создании тендера.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
