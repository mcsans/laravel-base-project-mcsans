<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:mc-service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a new service class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $names = explode('/', $this->argument('name'));
        $classname = end($names).'Service';

        $variable = strtolower(end($names));
        $pluralVariable = Str::plural($variable);

        if (count($names) > 1) {
            array_pop($names);
            $namespace = 'App\\Http\\Services\\Features\\' . implode('\\', $names);
        } else {
            $namespace = 'App\\Http\\Services\\Features';
        }

        $stubPath = resource_path('stubs/service.stub');
        $filePath = "{$namespace}/{$classname}.php";

        if (File::exists($filePath)) {
            $this->components->error("Service Already Exists.");
            return false;
        }

        $content = file_get_contents($stubPath);
        $content = str_replace(['{{namespace}}', '{{classname}}', '{{variable}}', '{{pluralVariable}}'], [$namespace, $classname, $variable, $pluralVariable], $content);

        $this->createDirectories($filePath);

        file_put_contents($filePath, $content);

        $this->components->info('Service Created Successfully.');
    }

    protected function createDirectories($filePath)
    {
        $directory = dirname($filePath);

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
    }
}
