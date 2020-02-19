<?php

namespace App\Transformers;

use App\Dto\Output\ReportDto;
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
        return (new ReportDto(
            $report->ReportID,
            $report->Title,
            $report->Synopsis,
            $report->ReportDate,
            $report->Pages,
            $report->AnalystIndex,
            optional($report->type)->Type
        ))->toArray();
    }
}
