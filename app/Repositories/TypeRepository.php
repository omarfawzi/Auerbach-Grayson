<?php

namespace App\Repositories;

use App\Models\SQL\Type;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TypeRepository
{
    /**
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function getTypes(int $limit) : LengthAwarePaginator
    {
        return Type::paginate($limit);
    }
}
