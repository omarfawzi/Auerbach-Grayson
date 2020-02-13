<?php

namespace App\Repositories;

use App\Models\SQL\Report;
use Illuminate\Database\Eloquent\Builder;

class ReportRepository
{
    /**
     * @param int $id
     * @return Report|null
     */
    public function getReportById(int $id): ?Report
    {
        return Report::findOrFail($id);
    }

    /**
     * @param string   $type
     * @param int|null $limit
     * @param int|null $page
     * @return Report[]|null
     */
    public function getReports(?string $type, int $limit = 15, int $page = 1): ?array
    {
        /** @var Builder $query */
        $query = Report::orderBy('DateEntered')->skip($limit * ($page - 1))->limit($limit);

        if ($type){
            $query->whereHas(
                'type',
                function (Builder $query) use ($type) {
                    $query->where('Type.Type', '=', $type);
                }
            );
        }

        return $query->get()->all();
    }
}
