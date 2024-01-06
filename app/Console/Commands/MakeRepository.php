<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository-contract {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a new repository and contract';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $names = explode('/', $this->argument('name'));

        $this->createContract($names);

        $this->createRepository($names);
    }

    protected function createDirectories($filePath)
    {
        $directory = dirname($filePath);

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
    }

    protected function createContract($names)
    {
        $classname = end($names).'Contract';

        if (count($names) > 1) {
            array_pop($names);
            $namespace = 'App\\Http\\Repositories\\Contracts\\' . implode('\\', $names);
        } else {
            $namespace = 'App\\Http\\Repositories\\Contracts';
        }

        $stubPath = resource_path('stubs/contract.stub');
        $filePath = "{$namespace}/{$classname}.php";

        if (File::exists($filePath)) {
            $this->components->error("Contract Already Exists.");
            return false;
        }

        $content = file_get_contents($stubPath);
        $content = str_replace(['{{namespace}}', '{{classname}}'], [$namespace, $classname], $content);

        $this->createDirectories($filePath);

        file_put_contents($filePath, $content);

        $this->components->info('Contract Created Successfully.');
    }

    protected function createRepository($names)
    {
        $contract = end($names).'Contract';
        $classname = end($names).'Repository';

        if (count($names) > 1) {
            array_pop($names);
            $namespace = 'App\\Http\\Repositories\\' . implode('\\', $names);
            $contractNamespace = 'App\\Http\\Repositories\\Contracts\\' . implode('\\', $names) . '\\' . $contract;
        } else {
            $namespace = 'App\\Http\\Repositories';
            $contractNamespace = 'App\\Http\\Repositories\\Contracts' . '\\' . $contract;
        }

        $stubPath = resource_path('stubs/repository.stub');
        $filePath = "{$namespace}/{$classname}.php";

        if (File::exists($filePath)) {
            $this->components->error("Repository Already Exists.");
            return false;
        }

        $repositoryContent = file_get_contents($stubPath);
        $repositoryContent = str_replace(['{{namespace}}', '{{contractNamespace}}', '{{classname}}', '{{contract}}'], [$namespace, $contractNamespace, $classname, $contract], $repositoryContent);

        $this->createDirectories($filePath);

        file_put_contents($filePath, $repositoryContent);

        $this->components->info('Repository Created Successfully.');
    }
}
