<?php

namespace App\Repositories;

use App\Models\SQL\Type;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TypeRepository
{
    /**
     * @param int   $limit
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getTypes(int $limit , array $filters = []) : LengthAwarePaginator
    {
        return Type::filter($filters)->paginate($limit);
    }
}
