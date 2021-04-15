<?php

namespace App\Models\SQL;
use App\Contracts\Mailable;
use Illuminate\Database\Eloquent\Model;

class AnalystDetail extends Model implements Mailable
{
    protected $connection = 'sqlsrv';

    protected $table = 'AnalystDetail';
}
