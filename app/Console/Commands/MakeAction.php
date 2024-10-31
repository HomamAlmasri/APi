<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class MakeAction extends Command
{
    protected $signature = 'make:Action {name}';
    protected $description = 'Create a new Action class';

    protected $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    public function handle()
    {
        $name = Str::studly( $this->argument('name'));
        $directory = app_path('Actions');
        $path = "{$directory}/{$name}.php";

        // Check if the Services directory exists, and create it if not
        if (!$this->files->exists($directory)) {
            $this->files->makeDirectory($directory, 0755, true);
            $this->info('Actions directory created.');
        }

        // Check if the service file already exists
        if ($this->files->exists($path))
        {
            $this->error('Action already exists!');
            return false;
        }

        // Get the stub and replace the placeholders
        $stub = $this->getStub();
        $this->files->put($path, $this->replacePlaceholders($stub, $name));

        $this->info("Action {$name} created successfully.");
    }


    protected function getStub()
    {
        return $this->files->get(app_path('console\stubs\action.stub'));
    }

    protected function replacePlaceholders($stub, $name)
    {

        return str_replace('{{ class }}', $name, $stub);
    }
}
