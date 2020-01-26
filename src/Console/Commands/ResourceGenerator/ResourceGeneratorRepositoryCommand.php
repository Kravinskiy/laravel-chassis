<?php

namespace Kravinskiy\LaravelChassis\Console\Commands\ResourceGenerator;

class ResourceGeneratorRepositoryCommand extends AbstractBaseResourceGeneratorCommand
{
    /**
     * @var string
     */
    protected const TYPE = 'Repository';

    /**
     * @var string
     */
    protected const PATH = '/Repositories/';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resource:generate:repository {name} {--resources=} {--crud}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate repository';

    /**
     * @throws \Exception
     */
    public function handle(): void
    {
        parent::handle();
        $this->setType(self::TYPE);
        $this->setPath(self::PATH);

        if ($this->isItCrud()) {
            $this->crudRepository();
            return;
        }

        $path = $this->generateResource('')['path'];
        $this->line('Repository generated, path: ' . $path);
    }

    /**
     * @throws \Exception
     */
    private function crudRepository(): void
    {
        if (in_array('Create', $this->getResources())) {
            $path = $this->generateResource('Create')['path'];
            $this->line('Create repository generated, path: ' . $path);
        }

        if (in_array('Get', $this->getResources())) {
            $path = $this->generateResource('Get')['path'];
            $this->line('Get repository generated, path: ' . $path);
        }

        if (in_array('Update', $this->getResources())) {
            $path = $this->generateResource('Update')['path'];
            $this->line('Update repository generated, path: ' . $path);
        }

        if (in_array('All', $this->getResources())) {
            $path = $this->generateResource('All')['path'];
            $this->line('All repository generated, path: ' . $path);
        }

        if (in_array('Delete', $this->getResources())) {
            $path = $this->generateResource('Delete')['path'];
            $this->line('Delete repository generated, path: ' . $path);
        }
    }
}
