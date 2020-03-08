<?php

namespace App\Factories;

use Carbon\Carbon;

class DateFactory
{
    /**
     * @param string $date
     * @return string
     */
    public function make(string $date) : string
    {
        switch ($date)
        {
            case 'today':
                return Carbon::today()->toDateTimeString();
            case 'week':
                return Carbon::now()->subWeek()->toDateTimeString();
            case 'month':
                return Carbon::now()->subMonth()->toDateTimeString();
            case 'year':
                return Carbon::now()->subYear()->toDateTimeString();
            default:
                return '';
        }
    }
}
