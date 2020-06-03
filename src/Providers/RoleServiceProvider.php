<?php

namespace Nksquare\Role\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Nksquare\Role\Console\Commands\RoleTable;
use Nksquare\Role\Middleware\RoleMiddleware;

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
        $this->app['router']->aliasMiddleware('role',RoleMiddleware::class);
    }

    protected function registerRoleBlueprint()
    {
        Blueprint::macro('role',function(){
            $this->roleColumn();
            $this->roleForeign();
        });

        Blueprint::macro('roleColumn',function(){
            return $this->string('role_id',20)->nullable();
        });

        Blueprint::macro('roleForeign',function(){
            return $this->foreign('role_id','nksquare_role_id_foreign')->references('id')->on(config('role.table'));
        });

        Blueprint::macro('dropRole',function(){
            $this->dropForeign('nksquare_role_id_foreign');
            return $this->dropColumn('role_id');
        });
    }
}
