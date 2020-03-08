<?php

namespace App\Repositories;

use App\Models\SQL\Sector;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SectorRepository
{
    /**
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function getSectors(int $limit) : LengthAwarePaginator
    {
        return Sector::paginate($limit);
    }
}
