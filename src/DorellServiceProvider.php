<?php
 
namespace Alihan0\LaravelDorell;
 
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
 
class DorellServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Alihan0\LaravelDorell\Common\Commands\Dorell::class
            ]);
        }
    }
}