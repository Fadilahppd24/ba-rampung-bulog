<?php

namespace App\Providers;

use App\Models\BaRampung;
use App\Policies\BaRampungPolicy;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(BaRampung::class, BaRampungPolicy::class);

        // Usage: @role('admin_gudang', 'admin_sistem') ... @endrole
        // Simple role-gated UI check. This is a *display* convenience only —
        // every action it wraps must still be protected server-side by the
        // `role` middleware and/or a Policy, same as the rest of the app.
        Blade::if('role', function (string ...$roles) {
            $user = auth()->user();
            return $user && in_array($user->role, $roles, true);
        });
    }
}
