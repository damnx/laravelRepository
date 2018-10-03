<?php

namespace App\Providers;

use App\Acl\DefinePolicies;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Roles' => 'App\Policies\RolePolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // check is_sadmin oke
        Gate::before(function ($user) {
            if ($user->is_sadmin) {
                return true;
            }
        });

        DefinePolicies::defineAbilities();

        Passport::routes();
        //
    }
}
