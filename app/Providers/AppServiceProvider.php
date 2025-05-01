<?php

namespace App\Providers;

use App\Models\Campaign;
use App\Policies\CampaignPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /*protected $policies = [
        Campaign::class => CampaignPolicy::class,
    ]; */

    public function boot()
    {
        Gate::policy(Campaign::class, CampaignPolicy::class);
    }
}
