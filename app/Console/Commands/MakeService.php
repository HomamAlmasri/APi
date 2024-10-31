<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class MakeService extends Command
{
    protected $signature = 'make:service {name}';
    protected $description = 'Create a new service class';

    protected $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    public function handle()
    {
        $name = Str::studly( $this->argument('name'));
        $directory = app_path('Services');
        $path = "{$directory}/{$name}.php";

        // Check if the Services directory exists, and create it if not
        if (!$this->files->exists($directory)) {
            $this->files->makeDirectory($directory, 0755, true);
            $this->info('Services directory created.');
        }

        // Check if the service file already exists
        if ($this->files->exists($path)) {
            $this->error('Service already exists!');
            return false;
        }

        // Get the stub and replace the placeholders
        $stub = $this->getStub();
        $this->files->put($path, $this->replacePlaceholders($stub, $name));

        $this->info("Service {$name} created successfully.");
    }

    protected function getStub()
    {
        return $this->files->get(app_path('console\stubs\service.stub'));
    }

    protected function replacePlaceholders($stub, $name)
    {
        return str_replace('{{ class }}', $name, $stub);
    }
}
