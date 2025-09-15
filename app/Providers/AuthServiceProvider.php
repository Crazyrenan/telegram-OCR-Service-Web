<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
     public function boot(): void
    {
        // This is the crucial rule.
        // It tells Laravel that a user can 'manage-users' only if their
        // 'role' column is exactly equal to 'manager'.
        Gate::define('manage-users', function (User $user) {
            return $user->role === 'manager';
        });
    }
}