<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserRequest;
use App\Http\Resources\Company\CompanyResource;
use App\Http\Resources\Tender\TenderBidResource;
use App\Http\Resources\Tender\TenderResource;
use App\Http\Resources\User\UserResource;
use App\Models\User\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return UserResource::collection($users);
    }

    public function show(User $user)
    {
        return UserResource::make($user);
    }

    public function update(User $user, UserRequest $request)
    {
        $user->update($request->validated());

        return response()->json([
            'message' => 'User updated success',
            'data' => UserResource::make($user),
        ]);
    }

    public function delete(User $user)
    {
        $user->delete();

        return response()->json(['message' => 'User deleted success'], 200);
    }

    public function getCompanies(User $user, Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 5);

        $companies = $user->companies()->paginate($perPage, ['*'], 'page', $page);

        return CompanyResource::collection($companies);
    }

    public function getTenders(User $user, Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 5);

        $tenders = $user->tenders()->paginate($perPage, ['*'], 'page', $page);

        return TenderResource::collection($tenders);
    }

    public function getBids(User $user, Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 5);

        $bids = $user->bids()->paginate($perPage, ['*'], 'page', $page);

        return TenderBidResource::collection($bids);
    }
}
