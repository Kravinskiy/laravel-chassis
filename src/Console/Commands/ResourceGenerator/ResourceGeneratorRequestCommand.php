<?php

namespace Kravinskiy\LaravelChassis\Console\Commands\ResourceGenerator;

class ResourceGeneratorRequestCommand extends AbstractBaseResourceGeneratorCommand
{
    /**
     * @var string
     */
    protected const TYPE = 'Request';

    /**
     * @var string
     */
    protected const PATH = '/Http/Requests/';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resource:generate:request {name} {--resources=} {--crud}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate request';

    /**
     * @throws \Exception
     */
    public function handle(): void
    {
        parent::handle();
        $this->setType(self::TYPE);
        $this->setPath(self::PATH);

        $this->deleteGitKeep();

        if ($this->isItCrud()) {
            $this->crudRequest();
            return;
        }

        $path = $this->generateResource('')['path'];
        $this->line('Request generated, path: ' . $path);
    }

    /**
     * @throws \Exception
     */
    private function crudRequest(): void
    {
        if (in_array('Create', $this->getResources())) {
            $path = $this->generateResource('Store')['path'];
            $this->line('Create request generated, path: ' . $path);
        }

        if (in_array('Get', $this->getResources())) {
            $path = $this->generateResource('Show')['path'];
            $this->line('Get request generated, path: ' . $path);
        }

        if (in_array('Update', $this->getResources())) {
            $path = $this->generateResource('Update')['path'];
            $this->line('Update request generated, path: ' . $path);
        }

        if (in_array('All', $this->getResources())) {
            $path = $this->generateResource('Index')['path'];
            $this->line('All request generated, path: ' . $path);
        }

        if (in_array('Delete', $this->getResources())) {
            $path = $this->generateResource('Destroy')['path'];
            $this->line('Delete request generated, path: ' . $path);
        }
    }

    /**
     * @return array
     */
    protected function getAllowedTypes(): array
    {
        return [
            'Destroy' => [
                'abstract' => 'AbstractBaseDestroyRequest',
            ],
            'Show' => [
                'abstract' => 'AbstractBaseShowRequest',
            ],
            'Store' => [
                'abstract' => 'AbstractBaseStoreRequest',
            ],
            'Index' => [
                'abstract' => 'AbstractBaseIndexRequest',
            ],
            'Update' => [
                'abstract' => 'AbstractBaseUpdateRequest',
            ],
            '' => [
                'abstract' => 'AbstractBaseRequest',
            ],
        ];
    }
}
