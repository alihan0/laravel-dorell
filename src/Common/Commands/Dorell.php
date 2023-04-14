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

        $controller_path = 'App/Http/Controller/';
        $model_path = 'App/Http/Model/';

        Artisan::call('make:controller '.$controller_name);
        Artisan::call('make:model '.$model_name);




        //Model içerisi güncellensin
        $filename = $model_path.$model_name.'.php';
        $file_contents = file_get_contents($filename);
        $search = 'use HasFactory;';
        $insert = 'protected $table = "'.$name.'";';

        // Dosyada search string'i arayın ve insert string'ini sonrasına ekleyin
        $file_contents = str_replace($search, $search . "\n\n" . $insert, $file_contents);

        // Dosyayı yeniden yazın
        file_put_contents($filename, $file_contents);





        $this->info('Controller ve model oluşturuldu');

    }
}