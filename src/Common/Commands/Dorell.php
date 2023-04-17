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

        $controller_path = app_path('Http/Controllers/'.$controller_name.'.php');
        $model_path = app_path('Models/'.$model_name.'.php');

        Artisan::call('make:controller '.$controller_name);
        $this->info('- Do:Rell # "'.$controller_name.'" controller has been created.');
        Artisan::call('make:model '.$model_name);
        $this->info('- Do:Rell # "'.$model_name.'" model has been created.');




        ///Model içeriği güncellensin
        if (file_exists($model_path)) {
            $file_contents = file_get_contents($model_path);
            $search = 'use HasFactory;';
            $insert = '
            protected $table = "'.$name.'";
            ';
        
            // Dosyada search string'i arayın ve insert string'ini sonrasına ekleyin
            $file_contents = str_replace($search, $search . "\n\n" . $insert, $file_contents);
        
            // Dosyayı yeniden yazın
            file_put_contents($model_path, $file_contents);
            $this->info('- Do:Rell # "'.$model_name.'" model content has been updated.');
        } else {
            $this->info('- Do:Rell !! Model File not found! : '.$model_path);
        }

        ///Controller içeriği güncellensin
        if (file_exists($controller_path)) {
            $file_contents = file_get_contents($controller_path);
            $insert = '<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\\'.$model_name.';

class '.$controller_name.' extends Controller
{

    // Response all post
    protected $response = ["type" => "warning", "message" => "'.$controller_name.' Response", "status" => false];

    // List All Datas
    public function all(){
        return view("rell.layout.'.$name.'.all", ["'.$name.'" => '.$model_name.'::all()]);
    }

    // Detail Selected Data
    public function detail($id){
        return view("rell.layout.'.$name.'.detail", ["'.$name.'" => '.$model_name.'::find($id)]);
    }

    // Add Ne Data;
    public function new(){
        return view("rell.layout.'.$name.'.new");
    }

    // Edit Selected Data
    public function edit($id){
        return view("rell.layout.'.$name.'.edit", ["'.$name.'" => '.$model_name.'::find($id)]);
    }

    // Insert New Data
    public function add(Request $request){
        $'.$name.' = new '.$model_name.';
        /* insert datas */

        if($'.$name.'->save()){
            $this->response["type"] = "success";
            $this->response["message"] = "New '.$model_name.' has been created.";
            $this->response["status"] = true;
        }else{
            $this->reponse["type"] = "error";
            $this->response["message"] = "SYSTEM_ERROR: Unknown insert failure";
        }
        return $this->response;
    }

    // Update Selected Data
    public function update(Request $request){
        $'.$name.' = '.$model_name.'::find($request->id);
        /* other controls */

        if($'.$name.'->save()){
            $this->response["type"] = "success";
            $this->response["message"] = "'.$model_name.' has been updated.";
            $this->response["status"] = true;
        }else{
            $this->reponse["type"] = "error";
            $this->response["message"] = "SYSTEM_ERROR: Unknown insert failure";
        }
        return $this->response;
    }

    // Delete Selected Data
    public function delete(Request $request){
        $'.$name.' = '.$model_name.'::find($request->id);

        if($'.$name.'){
            if($'.$name.'->delete()){
                $this->response["type"] = "success";
                $this->response["message"] = "'.$model_name.' row  has been deleted.";
                $this->response["status"] = true;
            }else{
                $this->reponse["type"] = "error";
                $this->response["message"] = "SYSTEM_ERROR: Unknown insert failure";
            }
        }
        return $this->response;
    }
}
            ';
        
            // Dosyayı yeniden yazın
            file_put_contents($controller_path, $insert);
            $this->info('- Do:Rell # "'.$controller_name.'" controller content has been updated.');
        } else {
            $this->info('- Do:Rell !! Controller File not found! : ' .$controller_name);
        }


        $route_path = '/routes/';
        $route_file = $route_file.'web.php';
        $file_contents = file_get_contents($route_file);
        $search = 'Route::get';
        $insert = '
        
        /n/n/n
        Route::controller('.$controller_name.'::class)->prefix('.$name.')->group(function(){
            Route::get("/", "all");
            Route::get("/detail/{id}", "detail");
            Route::get("/new", "new");
            Route::get("/edit/{id}", "edit");
            Route::post("/add", "add");
            Route::post("/update", "update");
            Route::post("/delete", "delete");
        });
        ';
    
        // Dosyada search string'i arayın ve insert string'ini sonrasına ekleyin
        $file_contents = str_replace($search, $search . "\n\n" . $insert, $file_contents);
    
        // Dosyayı yeniden yazın
        file_put_contents($route_file, $file_contents);
        $this->info('- Do:Rell # "Routes has been updated.');
    


        

    }
}