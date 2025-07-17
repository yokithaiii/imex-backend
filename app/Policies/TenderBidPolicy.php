<?php

namespace App\Policies;

use App\Models\Tender\TenderBid;
use App\Models\User\User;
use Illuminate\Auth\Access\Response;

class TenderBidPolicy
{
    public function view(User $user, TenderBid $bid)
    {
        return $user->id === $bid->user_id || $user->isAdmin();
    }

    public function update(User $user, TenderBid $bid)
    {
        return $user->id === $bid->user_id;
    }

    public function delete(User $user, TenderBid $bid)
    {
        return $user->id === $bid->user_id || $user->isAdmin();
    }
}
