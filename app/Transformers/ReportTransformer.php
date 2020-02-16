<?php

namespace App\Transformers;

use App\Models\SQL\Report;
use League\Fractal\TransformerAbstract;

class ReportTransformer extends TransformerAbstract
{
    public function transform(Report $report)
    {
        return [
            'id'    => $report->ReportID,
            'title' => $report->Title,
            'synopsis' => $report->Synopsis,
            'date' => $report->ReportDate,
            'pages' => $report->Pages,
            'by' => $report->AnalystIndex
        ];
    }
}
