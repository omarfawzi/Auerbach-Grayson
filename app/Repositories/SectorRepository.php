<?php

namespace App\Repositories;

use App\Models\SQL\Sector;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SectorRepository
{
    /**
     * @param int   $limit
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getSectors(int $limit , array $filters = []) : LengthAwarePaginator
    {
        return Sector::filter($filters)->paginate($limit);
    }
}
