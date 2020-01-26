<?php
declare(strict_types=1);

namespace Kravinskiy\LaravelChassis\Console\Commands\ResourceGenerator;

use Illuminate\Support\Facades\File;

class ResourceGeneratorControllerCommand extends AbstractBaseResourceGeneratorCommand
{
    /**
     * @var string
     */
    protected const TYPE = 'Controller';

    /**
     * @var string
     */
    protected const PATH = '/Http/Controllers/';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resource:generate:controller {name} {--crud} {--resources=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate controller';

    /**
     * @throws \Exception
     */
    public function handle(): void
    {
        parent::handle();
        $this->setType(self::TYPE);
        $this->setPath(self::PATH);

        if ($this->isItCrud()) {
            $this->crudController();
            return;
        }

        $path = $this->generateResource('')['path'];
        $this->line('Controller generated, path: ' . $path);
        $this->line('Route generated, uri: /api/' . $this->attributeLoweredPluralName);
    }

    /**
     * @param string $type
     * @return array
     * @throws \Exception
     */
    protected function generateResource(string $type): array
    {
        $resource = parent::generateResource($type);
        $typeConfig = $this->getAllowedTypes()[$type];

        // Add route to api.php
        File::append(
            base_path('routes/api.php'),
            PHP_EOL.
            "Route::{$typeConfig['action']}(".
            "'{$typeConfig['uri']}'".
            ", ".
            "'".$this->attributePluralName.
            "\\".$resource['className']."'".
            ");"
        );

        return $resource;
    }

    /**
     * @throws \Exception
     */
    private function crudController(): void
    {
        $this->line('Route generated, uri: /api/' . $this->attributeLoweredPluralName);

        if (in_array('Create', $this->getResources())) {
            $path = $this->generateResource('Store')['path'];
            $this->line('Store controller generated, path: ' . $path);
        }

        if (in_array('Get', $this->getResources())) {
            $path = $this->generateResource('Show')['path'];
            $this->line('Show controller generated, path: ' . $path);
        }

        if (in_array('All', $this->getResources())) {
            $path = $this->generateResource('Index')['path'];
            $this->line('Index controller generated, path: ' . $path);
        }

        if (in_array('Update', $this->getResources())) {
            $path = $this->generateResource('Update')['path'];
            $this->line('Update controller generated, path: ' . $path);
        }

        if (in_array('Delete', $this->getResources())) {
            $path = $this->generateResource('Destroy')['path'];
            $this->line('Destroy controller generated, path: ' . $path);
        }
    }

    /**
     * @return array
     */
    protected function getAllowedTypes(): array
    {
        return [
            'Destroy' => [
                'action' => 'delete',
                'abstract' => 'AbstractBaseDestroyController',
                'uri' => '/' . $this->attributeLoweredPluralName . '/{id}',
                'typeNameForDependencyInjection' => 'Delete',
            ],
            'Show' => [
                'action' => 'get',
                'abstract' => 'AbstractBaseShowController',
                'uri' => '/' . $this->attributeLoweredPluralName . '/{id}',
                'typeNameForDependencyInjection' => 'Get',
            ],
            'Store' => [
                'action' => 'post',
                'abstract' => 'AbstractBaseStoreController',
                'uri' => '/' . $this->attributeLoweredPluralName,
                'typeNameForDependencyInjection' => 'Create',
            ],
            'Index' => [
                'action' => 'get',
                'abstract' => 'AbstractBaseIndexController',
                'uri' => '/' . $this->attributeLoweredPluralName,
                'typeNameForDependencyInjection' => 'All',
            ],
            'Update' => [
                'action' => 'put',
                'abstract' => 'AbstractBaseUpdateController',
                'uri' => '/' . $this->attributeLoweredPluralName . '/{id}',
                'typeNameForDependencyInjection' => 'Update',
            ],
            '' => [
                'action' => 'get',
                'abstract' => 'AbstractBaseController',
                'uri' => '/' . $this->attributeLoweredPluralName,
            ],
        ];
    }
}
