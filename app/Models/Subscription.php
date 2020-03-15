<?php

namespace App\Models;

use App\Models\SQL\Company;
use App\Models\SQL\Sector;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class Subscription extends Model
{
    public const SECTOR_SUBSCRIPTION_TYPE = 'sector';
    public const COMPANY_SUBSCRIPTION_TYPE = 'company';
    public const SUBSCRIPTION_TYPES = [
        self::SECTOR_SUBSCRIPTION_TYPE,
        self::COMPANY_SUBSCRIPTION_TYPE
    ];
    protected $connection = 'mysql';

    public function subscribable()
    {
        return $this->morphTo();
    }

    /**
     * @param Request $request
     */
    public static function validate(Request $request)
    {
        $subscribableType = $request->get('type');
        $query = null;
        if ($subscribableType == Subscription::COMPANY_SUBSCRIPTION_TYPE) {
            $query = Company::getTableName() . ',' . Company::getPrimaryKey();
        }
        if ($subscribableType == Subscription::SECTOR_SUBSCRIPTION_TYPE) {
            $query = Sector::getTableName() . ',' . Sector::getPrimaryKey();
        }
        $validator = Validator::make(
            $request->all(['type']),
            [
                'type' => 'required|in:' . implode(',', Subscription::SUBSCRIPTION_TYPES)
            ]
        );
        $validator->validate();
        $validator = Validator::make(
            $request->all(['id']),
            [
                'id' => 'required|exists:sqlsrv.' . $query
            ]
        );
        $validator->validate();
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'type' => $this->subscribable_type,
            'subscribable' => optional($this->subscribable)->toArray()
        ];
    }

}
