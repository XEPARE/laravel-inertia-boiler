<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Laravel\Jetstream\Jetstream;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Prevent default routes
        Jetstream::ignoreRoutes();
        // Load own routes
        $this->loadRoutesFrom(base_path('routes/jetstream.php'));
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configurePermissions();
        $this->configureShares();

        Jetstream::deleteUsersUsing(DeleteUser::class);
    }

    /**
     * Configure the permissions that are available within the application.
     *
     * @return void
     */
    protected function configurePermissions()
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);

        if (Jetstream::hasTeamFeatures()) {
            Jetstream::role('admin', 'Administrator', [
                'create',
                'read',
                'update',
                'delete',
            ])->description('Administrator users can perform any action.');

            Jetstream::role('manager', 'Manager', [
                'create',
                'read',
                'update',
                'delete',
            ])->description('Manager users can create, read, update and delete any resources.');

            Jetstream::role('team-member', 'Team-Member', [
                'create',
                'read',
                'update',
            ])->description('Team-Member users can create, read and update resources.');

            Jetstream::role('viewer', 'Viewer', [
                'read',
            ])->description('Viewer users can only read resources.');
        }
    }

    function configureShares()
    {
        Inertia::share('auth', fn() => [
            'can' => user() ? user()->permissionsToArray() : [],
        ]);
    }

}
