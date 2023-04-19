<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Policies\PersonaPolicy;
use App\Policies\CitaPolicy;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //Persona::class => PersonaPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

        Gate::define('listar-persona', [PersonaPolicy::class, 'viewAny']);
        Gate::define('mostrar-persona', [PersonaPolicy::class, 'view']);
        Gate::define('crear-persona', [PersonaPolicy::class, 'create']);
        Gate::define('editar-persona', [PersonaPolicy::class, 'update']);

        Gate::define('listar-citas', [CitaPolicy::class, 'viewAny']);
        Gate::define('mostrar-citas', [CitaPolicy::class, 'view']);
        Gate::define('crear-citas', [CitaPolicy::class, 'create']);
        Gate::define('editar-citas', [CitaPolicy::class, 'update']);
    }
}
