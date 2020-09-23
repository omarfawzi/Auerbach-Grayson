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
    }
}
