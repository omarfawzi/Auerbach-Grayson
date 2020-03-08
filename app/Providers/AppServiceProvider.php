<?php

namespace App\Providers;

use App\Models\SQL\Company;
use App\Models\SQL\Sector;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Relation::morphMap([
            Subscription::COMPANY_SUBSCRIPTION_TYPE => Company::class,
            Subscription::SECTOR_SUBSCRIPTION_TYPE => Sector::class,
        ]);
    }

}
