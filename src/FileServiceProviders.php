<?php

namespace Alihan0\LaravelDorell;

use Illuminate\Support\Facades\File;

class FileServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $packageViewsDirectory = __DIR__.'/../resources/views';

        // dizinler
        $targetRellDirectory = resource_path('views/rell');
        $targetAdminDirectory = resource_path('views/admin');

        // Klasörlerin oluşturulması
        File::makeDirectory($targetRellDirectory, 0777, true, true);
        File::makeDirectory($targetRellDirectory.'/layout', 0777, true, true);
        File::makeDirectory($targetRellDirectory.'/src', 0777, true, true);
        File::makeDirectory($targetAdminDirectory, 0777, true, true);
        File::makeDirectory($targetAdminDirectory.'/layout', 0777, true, true);
        File::makeDirectory($targetAdminDirectory.'/src', 0777, true, true);

        // Dosyaların oluşturulması
        $rellMasterFile = $targetRellDirectory . '/master.blade.php';
        $rellAuthFile = $targetRellDirectory . '/auth.blade.php';
        $adminMasterFile = $targetRellDirectory . '/master.blade.php';
        $adminAuthFile = $targetRellDirectory . '/auth.blade.php';

        File::put($rellMasterFile, '');
        File::put($rellAuthFile, '');
        File::put($adminMasterFile, '');
        File::put($adminAuthFile, '');
    }
}