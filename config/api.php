<?php

use App\Constants\ReportDateFilter;

return [
    'defaults' => [
        'limit' => 20,
        'page' => 1
    ],
    'messages' => [
        'reset_password_email' => 'Password Sent to Email'
    ],
    'reports' => [
        'last_trend_date' => ReportDateFilter::YEAR
    ]
];
