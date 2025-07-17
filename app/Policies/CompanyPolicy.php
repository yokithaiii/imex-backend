<?php

namespace App\Policies;

use App\Models\Company\Company;
use App\Models\User\User;
use Illuminate\Auth\Access\Response;

class CompanyPolicy
{
    public function view(User $user, Company $company)
    {
        return $user->id === $company->user_id || $user->isAdmin();
    }

    public function update(User $user, Company $company)
    {
        return $user->id === $company->user_id;
    }

    public function delete(User $user, Company $company)
    {
        return $user->id === $company->user_id || $user->isAdmin();
    }
}
