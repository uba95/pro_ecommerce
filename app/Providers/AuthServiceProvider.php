<?php

namespace App\Providers;

use App\Model\Address;
use App\Model\Order;
use App\Policies\OrderPolicy;
use Laravel\Passport\Passport;
use App\Model\CancelOrderRequest;
use App\Model\ReturnOrderRequest;
use App\Policies\AddressPolicy;
use App\Policies\CancelOrderPolicy;
use App\Policies\ReturnOrderPolicy;
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
        // CancelOrderRequest::class => CancelOrderPolicy::class,
        // ReturnOrderRequest::class => ReturnOrderPolicy::class,
        Address::class => AddressPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        // Passport::routes();
    }
}
