<?php

namespace App\Repositories;

use App\Models\SQL\Region;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class RegionRepository
{
    /**
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function getRegions(int $limit) : LengthAwarePaginator
    {
        return Region::paginate($limit);
    }
}
