<?php


namespace App\Validators;

use App\Models\SQL\Company;
use App\Models\SQL\Sector;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionValidator
{
    /**
     * @param Request $request
     */
    public function validate(Request $request)
    {
        $subscribableType = $request->get('type');
        $subscribableId = $request->get('id');
        if ($subscribableType == Subscription::COMPANY_SUBSCRIPTION_TYPE) {
            $tableName = Company::getTableName();
            $primaryKey = Company::getPrimaryKey();
        }
        if ($subscribableType == Subscription::SECTOR_SUBSCRIPTION_TYPE) {
            $tableName = Sector::getTableName();
            $primaryKey = Sector::getPrimaryKey();
        }
        $validator = Validator::make(
            $request->all(['type']),
            [
                'type' => 'required|in:' . implode(',', Subscription::SUBSCRIPTION_TYPES)
            ]
        );
        $validator->validate();
        $validator = Validator::make(
            $request->all(['id', 'type']),
            [
                'id' => "required|exists:sqlsrv.$tableName,$primaryKey|unique:subscriptions,subscribable_id,NULL,id,subscribable_type,$subscribableType",
                'type' => "unique:subscriptions,subscribable_type,NULL,id,subscribable_id,$subscribableId"
            ]
        );
        $validator->validate();
    }
}
