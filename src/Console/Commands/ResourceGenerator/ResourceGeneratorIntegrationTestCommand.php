<?php

namespace Kravinskiy\LaravelChassis\Console\Commands\ResourceGenerator;

use Illuminate\Support\Facades\File;

class ResourceGeneratorIntegrationTestCommand extends AbstractBaseResourceGeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resource:generate:test {name} {--crud}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate integration test';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        parent::handle();
        $path = "/Tests/Integration/{$this->attributePluralName}Test.php";
        $template = $this->compileTemplate($this->attributeName, $this->attributePluralName);

        File::put(base_path($path), $template);
        $this->line('Test created, path: ' . $path);
    }

    /**
     * @param string $name
     * @param string $pluralName
     * @return string
     */
    private function compileTemplate(string $name, string $pluralName): string
    {
        return parent::replaceTemplate(
            [
                '{{modelName}}',
                '{{modelNameLowerCase}}',
                '{{modelNamePlural}}',
                '{{modelNamePluralLowerCase}}'
            ],
            [
                $name,
                strtolower($name),
                $pluralName,
                strtolower($pluralName)
            ],
            $this->isItCrud() ? 'IntegrationTestCrud' : 'IntegrationTest'
        );
    }
}
