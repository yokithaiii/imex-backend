<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tender\TenderBidRequest;
use App\Http\Requests\Tender\TenderBidUpdateRequest;
use App\Http\Resources\Tender\TenderBidResource;
use App\Models\Tender\Tender;
use App\Models\Tender\TenderBid;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class TenderBidController extends Controller
{
    use AuthorizesRequests;

    public function index(Tender $tender, Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 5);

        $bids = $tender->bids()->paginate($perPage, ['*'], 'page', $page);

        return TenderBidResource::collection($bids);
    }

    public function store(Tender $tender, TenderBidRequest $request)
    {
        $user = $request->user();

        if ($tender->bids()->where('user_id', $user->id)->exists()) {
            abort(400, 'Вы уже подали заявку на этот тендер');
        }

        $bid = $tender->bids()->create([
            ...$request->validated(),
            'tender_id' => $tender->id,
            'user_id' => $user->id
        ]);

        return response()->json([
            'message' => 'Tender bid created success',
            'data' => TenderBidResource::make($bid)
        ], 201);
    }

    public function show(Tender $tender, TenderBid $bid)
    {
        $this->authorize('view', $bid);

        return TenderBidResource::make($bid);
    }

    public function update(Tender $tender, TenderBid $bid, TenderBidUpdateRequest $request)
    {
        $this->authorize('update', $bid);

        $bid->update($request->validated());

        return response()->json([
            'message' => 'Заявка успешно обновлена',
            'data' => TenderBidResource::make($bid)
        ]);
    }

    public function delete(Tender $tender, TenderBid $bid)
    {
        $this->authorize('delete', $bid);

        $bid->delete();

        return response()->json(['message' => 'Tender bid deleted success'], 204);
    }
}
