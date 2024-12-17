<?php

namespace App\Providers;

use App\Models\User;
use App\Models\ResearchGrant;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('admin-executive', function (User $user) {
            return $user->role === 'Admin';
        });

        Gate::define('irmc-staff', function (User $user) {
            return $user->role === 'Staff';
        });

        Gate::define('project-leader', function (User $user) {
            return $user->role === 'Academician' && $user->academician && $user->academician->leadingGrants()->exists();
        });

        Gate::define('manage-grant', function (User $user, ResearchGrant $grant) {
            return $user->role === 'Admin' || 
                   ($user->academician && $grant->academician_id === $user->academician->id);
        });

        Gate::define('manage-members', function (User $user, ResearchGrant $grant) {
            return $user->role === 'Admin' || 
                   ($user->academician && $grant->academician_id === $user->academician->id);
        });

        Gate::define('manage-milestones', function (User $user, ResearchGrant $grant) {
            return $user->role === 'Admin' || 
                   ($user->academician && $grant->academician_id === $user->academician->id);
        });
    }
}
