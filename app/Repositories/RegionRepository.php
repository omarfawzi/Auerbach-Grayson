<?php

namespace App\Repositories;

use App\Models\SQL\Region;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class RegionRepository
{
    /**
     * @param int   $limit
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getRegions(int $limit , array $filters = []) : LengthAwarePaginator
    {
        return Region::filter($filters)->paginate($limit);
    }
}
