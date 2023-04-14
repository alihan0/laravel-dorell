<?php
 
namespace Alihan0\LaravelDorell\Common\Commands;
 

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

 
class Dorell extends Command
{

    protected $signature = 'do:rell {name}';
 
    protected $description = 'Automatical layout creator.';
 

    public function handle(): void
    {
        $name = $this->argument('name');

        $controller_name = ucfirst($name).'Controller';
        $model_name = ucfirst($name);

        $controller_path = app_path('Controllers/'.$controller_name.'.php');
        $model_path = app_path('Models/'.$model_name.'.php');

        Artisan::call('make:controller '.$controller_name);
        $this->info('#Do:Rell "'.$controller_name.'" controller has been created.');
        Artisan::call('make:model '.$model_name);
        $this->info('#Do:Rell "'.$model_name.'" model has been created.');




        ///Model içeriği güncellensin
        if (file_exists($model_path)) {
            $file_contents = file_get_contents($model_path);
            $search = 'use HasFactory;';
            $insert = 'protected $table = "'.$name.'";';
        
            // Dosyada search string'i arayın ve insert string'ini sonrasına ekleyin
            $file_contents = str_replace($search, $search . "\n" . $insert, $file_contents);
        
            // Dosyayı yeniden yazın
            file_put_contents($model_path, $file_contents);
            $this->info('#Do:Rell "'.$model_name.'" model content has been updated.');
        } else {
            $this->info('#Do:Rell ! Model File not found! : '.$model_path);
        }

        ///Controller içeriği güncellensin
        if (file_exists($controller_path)) {
            $file_contents = file_get_contents($controller_path);
            $search = 'extends Controller {';
            $insert = '
            
            public function all(){
                return view("rell.layout.'.$name.'.all", ["'.$name.'" => '.$model_name.'::all()]);
            }

            ';
        
            // Dosyada search string'i arayın ve insert string'ini sonrasına ekleyin
            $file_contents = str_replace($search, $search . "\n" . $insert, $file_contents);
        
            // Dosyayı yeniden yazın
            file_put_contents($controller_path, $file_contents);
            $this->info('#Do:Rell "'.$controller_name.'" model content has been updated.');
        } else {
            $this->info('#Do:Rell ! Controller File not found! : ' .$controller_name);
        }
        

    }
}