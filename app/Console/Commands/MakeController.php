<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeController extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:controller {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a new controller class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $names = explode('/', $this->argument('name'));
        $classname = end($names).'Controller';

        if (count($names) > 1) {
            array_pop($names);
            $namespace = 'App\\Http\\Controllers\\API\\' . implode('\\', $names);
        } else {
            $namespace = 'App\\Http\\Controllers\\API';
        }

        $stubPath = resource_path('stubs/controller.stub');
        $filePath = "{$namespace}/{$classname}.php";

        if (File::exists($filePath)) {
            $this->components->error("Controller Already Exists.");
            return false;
        }

        $content = file_get_contents($stubPath);
        $content = str_replace(['{{namespace}}', '{{classname}}'], [$namespace, $classname], $content);

        $this->createDirectories($filePath);

        file_put_contents($filePath, $content);

        $this->components->info('Controller Created Successfully.');
    }

    protected function createDirectories($filePath)
    {
        $directory = dirname($filePath);

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
    }
}
