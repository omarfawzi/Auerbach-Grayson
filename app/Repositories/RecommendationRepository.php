<?php

namespace App\Repositories;

use App\Schema\Recommendation;
use Illuminate\Pagination\LengthAwarePaginator;

class RecommendationRepository
{
    /**
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function getRecommendations(int $limit) : LengthAwarePaginator
    {
        return Recommendation::paginate($limit);
    }
}
