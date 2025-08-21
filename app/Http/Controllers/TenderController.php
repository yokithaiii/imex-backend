<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tender\TenderBidRequest;
use App\Http\Requests\Tender\TenderRequest;
use App\Http\Requests\Tender\TenderStatusRequest;
use App\Http\Requests\Tender\TenderUpdateRequest;
use App\Http\Resources\Tender\TenderDetailResource;
use App\Http\Resources\Tender\TenderResource;
use App\Models\Tender\Tender;
use App\Services\TenderService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TenderController extends Controller
{
    public function __construct(TenderService $tenderService)
    {
        $this->tenderService = $tenderService;
    }

    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 5);

        $tenders = Tender::query()
            ->where('status', '=', 'published')
            ->paginate($perPage, ['*'], 'page', $page);

        return TenderResource::collection($tenders);
    }

    public function getCreatedTenders(Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 5);

        $tenders = Tender::query()
            ->where('user_id', $request->user()->id)
            ->paginate($perPage, ['*'], 'page', $page);

        return TenderResource::collection($tenders);
    }

    public function getParticipatedTenders(Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 5);

        $tenders = Tender::query()
            ->where('status', '=', 'published')
            ->paginate($perPage, ['*'], 'page', $page);

        return TenderResource::collection($tenders);
    }

    public function store(TenderRequest $request)
    {
        $validatedData = $request->validated();
        $user = $request->user();

        $validatedData['user_id'] = $user->id;

        return $this->tenderService->createTender($validatedData);
    }

    public function show(Tender $tender)
    {
        return TenderDetailResource::make($tender);
    }

    public function update(Tender $tender, TenderUpdateRequest $request)
    {
        $validatedData = $request->validated();

        $tender->update($validatedData);

        return response()->json(['message' => 'Tender updated success'], 200);
    }

    public function changeStatus(Tender $tender, TenderStatusRequest $request)
    {
        $validatedData = $request->validated();
        $user = $request->user();

        if ($user->id !== $tender->user_id) {
            return response()->json(['error' => 'You cant change status this tender'], 400);
        }

        $tender->status = $validatedData['status'];
        if ($validatedData['status'] === 'published') {
            $tender->published_at = Carbon::now();
        } else {
            $tender->published_at = null;
        }

        $tender->save();

        return response()->json(['message' => 'Tender changed status success'], 200);
    }

    public function bid(Tender $tender, TenderBidRequest $request)
    {

    }

    public function delete(Tender $tender, Request $request)
    {
        if ($request->user()->id !== $tender->user_id) {
            return response()->json(['error' => 'You cant delete this tender'], 400);
        }

        $tender->delete();

        return response()->json(['message' => 'Tender deleted success'], 200);
    }
}
