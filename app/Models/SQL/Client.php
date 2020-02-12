<?php

namespace App\Models\SQL;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'Client';

    protected $primaryKey = 'ClientID';

    /**
     * @return string
     */
    public function getEmail() : string
    {
        return  $this->Email;
    }
}
