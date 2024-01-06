<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeResource extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:resource {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a new resource';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $names = explode('/', $this->argument('name'));
        $endName = end($names);
        $classname = $endName.'Resource';

        if (count($names) > 1) {
            $namespace = 'App\\Http\\Resources\\' . implode('\\', $names);
        } else {
            $namespace = 'App\\Http\\Resources\\' . $endName;
        }

        $stubPath = resource_path('stubs/resource.stub');
        $filePath = "{$namespace}/{$classname}.php";

        if (File::exists($filePath)) {
            $this->components->error("Resource Already Exists.");
            return false;
        }

        $content = file_get_contents($stubPath);
        $content = str_replace(['{{namespace}}', '{{classname}}'], [$namespace, $classname], $content);

        $this->createDirectories($filePath);

        file_put_contents($filePath, $content);

        $this->components->info('Resource Created Successfully.');
    }

    protected function createDirectories($filePath)
    {
        $directory = dirname($filePath);

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
    }
}
