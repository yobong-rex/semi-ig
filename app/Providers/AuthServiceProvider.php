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

        Gate::define('isMarketing', function($user){
            if( $user->role == 'Marketing'){
                return Response::allow();
            } else {
                return Response::deny('Hanya Untuk Marketing');
            }
        });

        Gate::define('isResearcher', function($user){
            if ($user->role == 'Researcher'){
                return Response::allow();
            } else {
                return Response::deny('Hanya Untuk Researcher');
            }
        });

        Gate::define('isProduction_Manager', function($user){
            if ($user->role == 'Production Manager'){
                return Response::allow();
            } else {
                return Response::deny('Hanya Untuk Production Manager');
            }
        });


        Gate::define('isAdmin', function($user){
            if ($user->role == 'Admin'){
                return Response::allow();
            } else {
                return Response::deny('Hanya Untuk Admin');
            }
        });

        Gate::define('isSI', function($user){
            if ($user->role == 'SI'){
                return Response::allow();
            } else {
                return Response::deny('Hanya Untuk Admin');
            }
        });

        //
    }
}
