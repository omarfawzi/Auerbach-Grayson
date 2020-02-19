<?php

namespace App\Transformers;

use App\Models\SQL\Report;
use League\Fractal\TransformerAbstract;

class ReportTransformer extends TransformerAbstract
{
    /**
     * @param Report $report
     * @return array
     */
    public function transform(Report $report): array
    {
        return $report->toArray();
    }
}
