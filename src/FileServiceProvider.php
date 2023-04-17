<?php

namespace Alihan0\LaravelDorell;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Command;

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

        if(file_exists($targetRellDirectory)){
            $this->info('- Do:Rell # Rell directory already exist.');
        }elseif(file_exists($targetAdminDirectory)){
            $this->info('- Do:Rell # Admin directtory alreay exist.');
        }else{
             // Klasörlerin oluşturulması
        File::makeDirectory($targetRellDirectory, 0777, true, true);
        File::makeDirectory($targetRellDirectory.'/layout', 0777, true, true);
        File::makeDirectory($targetRellDirectory.'/src', 0777, true, true);
        File::makeDirectory($targetRellDirectory.'/layout/auth', 0777, true, true);
        File::makeDirectory($targetRellDirectory.'/layout/main', 0777, true, true);

        File::makeDirectory($targetAdminDirectory, 0777, true, true);
        File::makeDirectory($targetAdminDirectory.'/layout', 0777, true, true);
        File::makeDirectory($targetAdminDirectory.'/src', 0777, true, true);
        File::makeDirectory($targetAdminDirectory.'/layout/auth', 0777, true, true);
        File::makeDirectory($targetAdminDirectory.'/layout/main', 0777, true, true);

        // Dosyaların oluşturulması
        $rellMasterFile = $targetRellDirectory . '/master.blade.php';
        $rellAuthFile = $targetRellDirectory . '/auth.blade.php';
        $rellLoginFile = $targetRellDirectory . '/layout/auth/login.blade.php';
        $rellRegisterFile = $targetRellDirectory . '/layout/auth/register.blade.php';
        $rellLockFile = $targetRellDirectory . '/layout/auth/lock.blade.php';
        $rellResetPasswordFile = $targetRellDirectory . '/layout/auth/reset-password.blade.php';
        $rellHomeFile = $targetRellDirectory . '/layout/main/home.blade.php';

        $adminMasterFile = $targetAdminDirectory . '/master.blade.php';
        $adminAuthFile = $targetAdminDirectory . '/auth.blade.php';
        $adminLoginFile = $targetAdminDirectory . '/layout/auth/login.blade.php';
        $adminRegisterFile = $targetAdminDirectory . '/layout/auth/register.blade.php';
        $adminLockFile = $targetAdminDirectory . '/layout/auth/lock.blade.php';
        $adminResetPasswordFile = $targetAdminDirectory . '/layout/auth/reset-password.blade.php';
        $adminHomeFile = $targetAdminDirectory . '/layout/main/home.blade.php';

        File::put($rellMasterFile, '');
        File::put($rellAuthFile, '');
        File::put($rellLoginFile, '');
        File::put($rellRegisterFile, '');
        File::put($rellResetPasswordFile, '');
        File::put($rellHomeFile, '');

        File::put($adminMasterFile, '');
        File::put($adminAuthFile, '');
        File::put($adminLoginFile, '');
        File::put($adminRegisterFile, '');
        File::put($adminLockFile, '');
        File::put($adminHomeFile, '');

        $this->info('- Do:Rell # The folder structure has been created.');
        }
    }
}