<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeCRUD extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a new model, controller, service, repository, contract, request and resource';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $names = explode('/', $this->argument('name'));
        $endName = end($names);

        array_pop($names);
        $namespace = implode('\\', $names);

        if (!File::exists("App\\Models\\{$name}.php")) {
            exec("php artisan make:model {$name} -m");
            $this->components->info('Model Created Successfully.');
        } else {
            $this->components->error('Model already exists.');
            return false;
        }

        if (!File::exists("App\\Http\\Controllers\\API\\{$name}Controller.php")) {
            exec("php artisan make:controller {$name}");
            $this->components->info('Controller Created Successfully.');
        } else {
            $this->components->error('Controller already exists.');
            return false;
        }

        if (!File::exists("App\\Http\\Services\\Features\\{$name}Service.php")) {
            exec("php artisan make:service {$name}");
            $this->components->info('Service Created Successfully.');
        } else {
            $this->components->error('Service already exists.');
            return false;
        }

        if (!File::exists("App\\Http\\Repositories\\{$name}Repository.php")) {
            exec("php artisan make:repository-contract {$name} --model={$endName}");
            $this->components->info('Repository-Contract Created Successfully.');
        } else {
            $this->components->error('Repository-Contract already exists.');
            return false;
        }

        if (!File::exists("App\\Http\\Requests\\API\\{$name}\\Store{$endName}Validation.php")) {
            exec("php artisan make:request {$name}");
            $this->components->info('Store-Update Request Created Successfully.');
        } else {
            $this->components->error('Request already exists.');
            return false;
        }

        if (!File::exists("App\\Http\\Resources\\{$name}\\{$endName}Resource.php")) {
            exec("php artisan make:resource {$name}");
            $this->components->info('Resource Created Successfully.');
        } else {
            $this->components->error('Resource already exists.');
            return false;
        }
    }
}
