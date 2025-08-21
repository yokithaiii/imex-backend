<?php

namespace App\Http\Controllers;

use App\Http\Requests\Bid\BidRequest;
use App\Http\Resources\Tender\TenderBidResource;
use App\Models\Tender\Tender;
use App\Models\Tender\TenderBid;
use Illuminate\Http\Request;

class BidController extends Controller
{
    public function index(Tender $tender, Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = $request->get('perPage', 10);

        $bids = TenderBid::query()
            ->where('tender_id', $tender->id)
            ->paginate($perPage, ['*'], 'page', $page);

        return TenderBidResource::collection($bids);
    }

    public function store(Tender $tender, BidRequest $request)
    {
        $validatedData = $request->validated();

        if ($tender->user_id === $request->user()->id) {
            return response()->json(['error' => 'Вы не можете участвовать в своем тендере'], 403);
        }

        if ($validatedData['price'] < $tender->start_price) {
            return response()->json(['error' => 'Вы не можете указать цену ниже чем начальаня цена в тендере'], 403);
        }

        $tenderBidExists = TenderBid::query()
            ->where('tender_id', $tender->id)
            ->where('user_id', $request->user()->id)
            ->exists();

        if ($tenderBidExists) {
            return response()->json(['error' => 'Вы уже подали заявку на участие в этом тендере'], 400);
        }

        $tenderBid = TenderBid::query()->create([
            'user_id' => $request->user()->id,
            'tender_id' => $tender->id,
            'company_id' => $validatedData['company_id'],
            'price' => $validatedData['price'],
            'date' => $validatedData['date'],
        ]);

        return response()->json([
            'message' => 'Ваша заявка успешно создана',
            'data' => TenderBidResource::make($tenderBid),
        ], 201);
    }
}
