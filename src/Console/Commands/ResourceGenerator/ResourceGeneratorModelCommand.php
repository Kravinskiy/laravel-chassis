<?php

namespace Kravinskiy\LaravelChassis\Console\Commands\ResourceGenerator;

use Illuminate\Support\Facades\File;

class ResourceGeneratorModelCommand extends AbstractBaseResourceGeneratorCommand
{
    protected const PATH = '/Models/';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resource:generate:model {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate model';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        parent::handle();
        $this->setPath(self::PATH);

        $path = $this->getPath() . $this->attributeName .'.php';
        $template = $this->compileTemplate($this->attributeName);

        File::put(app_path($path), $template);

        $this->deleteGitKeep();
        $this->line('Model created, path: ' . $path);
    }

    /**
     * @param string $name
     * @return string
     */
    private function compileTemplate(string $name): string
    {
        return parent::replaceTemplate(
            ['{{modelName}}'],
            [$name],
            'Model'
        );
    }
}
