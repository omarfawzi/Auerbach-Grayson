<?php

namespace App\Repositories;

use App\Auth;
use App\Models\ReportWeight;

class ReportWeightRepository
{
    /**
     * @param string $order
     * @return array
     */
    public function getWeightedCompanyIds(string $order = 'desc'): array
    {
        $userId = Auth::getAuthenticatedUser()->id;

        return ReportWeight::query()->select('company_id')
            ->where('user_id',$userId)
            ->orderBy('weight', $order)
            ->groupBy('company_id')->get()->pluck('company_id')->toArray();
    }
}
