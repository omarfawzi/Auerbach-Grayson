<?php

namespace App\Providers;

use App\Models\SQL\Company;
use App\Models\SQL\Sector;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */

    public function boot()
    {
        DB::listen(function($query) {
            File::append(
                storage_path('/logs/query.log'),
                $query->sql . ' [' . implode(', ', $query->bindings) . ']' . PHP_EOL
            );
        });
    }

    public function register()
    {
        Validator::extend('check_hashed_pass', function($attribute, $value, $parameters)
        {
            if( ! Hash::check( $value , $parameters[0] ) )
            {
                return false;
            }
            return true;
        });

        Relation::morphMap([
            Subscription::COMPANY_SUBSCRIPTION_TYPE => Company::class,
            Subscription::SECTOR_SUBSCRIPTION_TYPE => Sector::class,
        ]);
    }

}
