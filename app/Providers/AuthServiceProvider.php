<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isEditor', function($user) {
            return $user->role == 'manager';
        });

        Gate::define('isMarketing', function($user){
            return $user->role == 'Marketing';
        });

        Gate::define('isResearcher', function($user){
            return $user->role == 'Researcher';
        });

        Gate::define('isProduction_Manager', function($user){
            return $user->role == 'Production Manager';
        });

        
        Gate::define('isAdmin', function($user){
            return $user->role == 'Admin';
        });

        //
    }
}
