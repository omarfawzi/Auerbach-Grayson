<?php

namespace App\Models\SQL;

use App\Contracts\Mailable;
use Illuminate\Database\Eloquent\Model;

class Analyst extends Model implements Mailable
{
    protected $connection = 'sqlsrv';

    protected $table = 'Analyst';

    protected $primaryKey = 'AnalystID';

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
}
