<?php

namespace Kravinskiy\LaravelChassis\Console\Commands\ResourceGenerator;

use Kravinskiy\LaravelChassis\Exceptions\Console\InvalidArgumentException;
use RuntimeException;
use Kravinskiy\LaravelChassis\Helpers\StubHelper;
use Kravinskiy\LaravelChassis\Rules\ElementsAreInArrayRule;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

abstract class AbstractBaseResourceGeneratorCommand extends Command
{
    /**
     * @var string
     */
    protected $attributeName;

    /**
     * @var string
     */
    protected $attributePluralName;

    /**
     * @var string
     */
    protected $attributeLowPluralName;

    /**
     * @var string
     */
    protected $attributeLoweredPluralName;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $path;

    /**
     * @var array
     */
    protected $resources = ['Create', 'Update', 'Get', 'All', 'Delete'];

    /**
     * @var array
     */
    protected $allowedResources = ['Create', 'Update', 'Get', 'All', 'Delete', 'Store', 'Show', 'Index', 'Destroy', ''];

    /**
     * @var bool
     */
    private $isItCrud = false;

    /**
     * @return string
     */
    protected function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return void
     */
    protected function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    protected function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    protected function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * @return array
     */
    protected function getResources(): array
    {
        return $this->resources;
    }

    /**
     * @return array
     */
    protected function getAllowedResources(): array
    {
        return $this->allowedResources;
    }

    /**
     * @param string $resources
     * @return void
     */
    protected function setResources(string $resources): void
    {
        $resources = explode(',', $resources);

        // Validation
        Validator::make(['resource' => $resources], [
            'resource' => [
                'required',
                new ElementsAreInArrayRule($this->getAllowedResources(), $resources)
            ]
        ])->validate();

        $this->resources = $resources;
    }

    /**
     * @return bool
     */
    public function isItCrud(): bool
    {
        return $this->isItCrud;
    }

    /**
     * @param bool $isItCrud
     */
    public function setIsItCrud(bool $isItCrud): void
    {
        $this->isItCrud = $isItCrud;
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        /** @var string $name */
        $name = $this->argument('name');

        if ($this->hasOption('resources')) {
            /** @var string $resources */
            $resources = $this->option('resources');
        }

        if ($this->hasOption('crud')) {
            $crud = $this->option('crud');
        }

        if (!empty($resources)) {
            $this->setResources($resources);
        }

        if (!empty($crud)) {
            $this->setIsItCrud(true);
        }

        $this->attributeName = $name;
        $this->attributePluralName = Str::plural($this->attributeName);
        $this->attributeLowPluralName = strtolower($this->attributePluralName);
        $this->attributeLoweredPluralName = strtolower($this->attributePluralName);
    }

    /**
     * @param array $replaceFrom
     * @param array $replaceTo
     * @param string $type
     * @return string
     */
    protected function replaceTemplate(array $replaceFrom, array $replaceTo, string $type): string
    {
        $template = str_replace(
            $replaceFrom,
            $replaceTo,
            StubHelper::getResourceStubs($type)
        );

        return $template;
    }

    /**
     * @param string $type
     * @return array
     * @throws \Exception
     */
    protected function generateResource(string $type): array
    {
        $this->validateResourceGeneration($type);

        $allowedTypes = $this->getAllowedTypes();
        $typeConfig = $allowedTypes[$type];
        $typeAndAttribute = $type . $this->attributePluralName;
        $className = $type . $this->attributePluralName . $this->getType();

        // Get template
        $template = $this->replaceTemplate(
            [
                '{{modelNamePlural}}',
                '{{abstract}}',
                '{{domainNamePlural}}',
                '{{domainName}}',
                '{{nameForDependencyInjection}}'
            ],
            [
                $typeAndAttribute,
                $typeConfig['abstract'],
                $this->attributePluralName,
                $this->attributeName,
                isset($typeConfig['typeNameForDependencyInjection']) ?
                    $typeConfig['typeNameForDependencyInjection'] . $this->attributePluralName : $typeAndAttribute
            ],
            $this->getType()
        );

        // Create directory
        $directory = $this->createDirectory();

        // Create file and fill it with content from template
        $path = $this->createFile($directory, $className, $template);

        return [
            'path' => $path,
            'className' => $className
        ];
    }

    /**
     * @return array
     */
    protected function getAllowedTypes(): array
    {
        return [
            'Create' => [
                'abstract' => 'AbstractBaseCreate' . $this->getType()
            ],
            'All' => [
                'abstract' => 'AbstractBaseAll' . $this->getType()
            ],
            'Get' => [
                'abstract' => 'AbstractBaseGet' . $this->getType()
            ],
            'Update' => [
                'abstract' => 'AbstractBaseUpdate' . $this->getType()
            ],
            'Delete' => [
                'abstract' => 'AbstractBaseDelete' . $this->getType()
            ],
            '' => [
                'abstract' => 'AbstractBase' . $this->getType()
            ]
        ];
    }

    /**
     * @param string $directory
     * @return void
     */
    protected function deleteGitKeep(string $directory = ''): void
    {
        $actualDirectory = app_path($directory);

        if (empty($directory)) {
            $actualDirectory = base_path($directory);
        }

        $gitKeepFile = $actualDirectory . '/.gitkeep';

        if (File::exists($gitKeepFile)) {
            File::delete($gitKeepFile);
        }
    }

    /*
     * @return void
     */
    protected function whatResources(): void
    {
        $whatResources = '';

        if (!$this->isItCrud()) {
            $crudResource = $this->askWithCompletion(
                'Do you want to generated CRUD resources? (yes/no)',
                ['yes', 'no'],
                'yes'
            );

            if ($crudResource === 'yes') {
                $this->setIsItCrud(true);
            }
        }

        if ($this->isItCrud) {
            $whatResources = $this->ask(
                'Which of these actions do you want to generate (by default, all of them)? Separate with commas.',
                implode(',', $this->getResources())
            );
        }

        $this->setResources($whatResources);
    }

    /**
     * @param string $type
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     * @return void
     */
    private function validateResourceGeneration(string $type): void
    {
        if (empty($this->getPath()) || empty($this->getType())) {
            throw new RuntimeException('Path and type must be defined if using generateResource()');
        }

        $allowedTypes = $this->getAllowedTypes();

        if (empty($allowedTypes)) {
            throw new RuntimeException('getAllowedTypes() can not be null if using generateResource()');
        }

        if (!isset($allowedTypes[$type])) {
            throw new InvalidArgumentException('Invalid argument given, ' . $type . ' does not exist');
        }
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function createDirectory(): string
    {
        $directory = $this->getPath() . $this->attributePluralName . '/';
        if (File::exists(app_path($directory)) === false) {
            File::makeDirectory(app_path($directory));
        }

        return $directory;
    }

    /**
     * @param string $directory
     * @param string $className
     * @param string $template
     * @throws \Exception
     * @return string
     */
    protected function createFile(string $directory, string $className, string $template): string
    {
        $path = $directory . $className . '.php';
        File::put(app_path($path), $template);

        return $path;
    }
}
