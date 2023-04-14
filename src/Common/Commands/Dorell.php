<?php
 
namespace Alihan0\LaravelDorell\Common\Commands;
 

use Illuminate\Console\Command;
 
class Dorell extends Command
{

    protected $signature = 'do:rell {name}';
 
    protected $description = 'Automatical layout creator.';
 

    public function handle(): void
    {
        $name = $this->argument('name');

        $this->info('seçilen isim: '.$name);
    }
}