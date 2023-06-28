<?php

namespace App\Providers;

use App\Model\User;
use App\Policies\BookingPolicy;
use App\Policies\MoviePolicy;
use App\Policies\ShowPolicy;
use App\Policies\TheaterPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();

        Gate::resource('users', UserPolicy::class);
        Gate::resource('movies', MoviePolicy::class);
        Gate::resource('shows', ShowPolicy::class);
        Gate::resource('theaters', TheaterPolicy::class);
        Gate::resource('bookings', BookingPolicy::class);
        Gate::define('bookings.viewAllOf', [BookingPolicy::class, 'viewAllOf']);
    }
}
