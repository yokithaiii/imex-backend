<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function createMaintenance(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
        ]);

        // todo: send to admin panel for moderate

        return response()->json(['message' => 'Ваша заявка успешно подана!'], 201);
    }

    public function getIncomes(Request $request)
    {
        $filterType = $request->query('type') ?? 'all';
        if ($filterType == 'income' || $filterType == 'potential' || $filterType == 'all') {
            $type = $request->query('type');
        } else {
            return response()->json(['error' => 'Invalid filter type'], 400);
        }

        $filterPeriod = $request->query('period') ?? 'all';
        if ($filterPeriod == 'all' || $filterPeriod == 'week' || $filterPeriod == 'month' || $filterPeriod == 'year') {
            $period = $request->query('period');
        } else {
            return response()->json(['error' => 'Invalid filter period'], 400);
        }

        $res = [
            'income' => [],
            'potential' => [],
        ];

        return response()->json(['data' => $res], 200);
    }

    public function getTenders(Request $request)
    {
        $filterPeriod = $request->query('period') ?? 'all';
        if ($filterPeriod == 'all' || $filterPeriod == 'week' || $filterPeriod == 'month' || $filterPeriod == 'year') {
            $period = $request->query('period');
        } else {
            return response()->json(['error' => 'Invalid filter'], 400);
        }

        $res = [
            'tenders' => 100,
            'won' => 33,
        ];

        return response()->json(['data' => $res], 200);
    }
}
