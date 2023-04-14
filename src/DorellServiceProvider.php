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
        dd("provider okundu!");
    }
}