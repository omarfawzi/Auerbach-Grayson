<?php

namespace App\Factories;

use App\Constants\ReportDateFilter;
use Carbon\Carbon;

class DateFactory
{
    /**
     * @param string $date
     * @return string
     */
    public function make(string $date): string
    {
        switch ($date) {
            case ReportDateFilter::TODAY:
                return Carbon::today()->toDateTimeString();
            case ReportDateFilter::WEEK:
                return Carbon::now()->subWeek()->toDateTimeString();
            case ReportDateFilter::MONTH:
                return Carbon::now()->subMonth()->toDateTimeString();
            case ReportDateFilter::YEAR:
                return Carbon::now()->subYear()->toDateTimeString();
            default:
                return '';
        }
    }
}
