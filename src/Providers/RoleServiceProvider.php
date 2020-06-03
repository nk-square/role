<?php

namespace Nksquare\Role\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Nksquare\Role\Console\Commands\RoleTable;

class RoleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRoleBlueprint();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ .'/../config/role.php', 'role');

        $this->publishes([
            __DIR__.'/../config/role.php' => config_path('role.php')
        ],'nksquare-role-config');

        if ($this->app->runningInConsole()) 
        {
            $this->commands([
                RoleTable::class
            ]);
        }
    }

    protected function registerRoleBlueprint()
    {
        Blueprint::macro('role',function(){
            $this->string('role_id',20);
            $this->foreign('role_id')->references->('id')->on(config('role.table'));
        });
    }
}
