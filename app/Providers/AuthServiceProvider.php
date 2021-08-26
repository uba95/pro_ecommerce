<?php

namespace App\Providers;

use App\Models\Address;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Role;
use App\Policies\OrderPolicy;
use App\Policies\AddressPolicy;
use App\Policies\AdminPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Order::class => OrderPolicy::class,
        Address::class => AddressPolicy::class,
        Admin::class => AdminPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($admin, $ability) {
            return $admin instanceof Admin && $admin->hasRole(Role::SUPER_ADMIN) ? true : null;
        });
    }
}
