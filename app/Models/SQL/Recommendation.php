<?php

namespace App\Models\SQL;

use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'Recommendation';

    protected $primaryKey = 'RecommendID';
}
