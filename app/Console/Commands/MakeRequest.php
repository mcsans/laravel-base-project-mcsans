<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:mc-request {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a new form request class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $names = explode('/', $this->argument('name'));

        $this->createRequestValidation($names, 'Index');

        $this->createRequestValidation($names, 'Store');

        $this->createRequestValidation($names, 'Update');
    }

    protected function createDirectories($filePath)
    {
        $directory = dirname($filePath);

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
    }

    public function createRequestValidation($names, $process)
    {
        $endName = end($names);
        $classname = "{$process}{$endName}Request";

        if (count($names) > 1) {
            $namespace = 'App\\Http\\Requests\\API\\' . implode('\\', $names);
        } else {
            $namespace = 'App\\Http\\Requests\\API\\' . $endName;
        }

        $stubPath = resource_path('stubs/request.stub');
        $filePath = "{$namespace}/{$classname}.php";

        if (File::exists($filePath)) {
            $this->components->error("{$process} Request Already Exists.");
            return false;
        }

        $content = file_get_contents($stubPath);
        $content = str_replace(['{{namespace}}', '{{classname}}'], [$namespace, $classname], $content);

        $this->createDirectories($filePath);

        file_put_contents($filePath, $content);

        $this->components->info("{$process} Request Created Successfully.");
    }
}
