<?php

namespace Kravinskiy\LaravelChassis\Console\Commands\ResourceGenerator;

class ResourceGeneratorAllCommand extends AbstractBaseResourceGeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resource:generate {name} {--resources=} {--crud}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Wizard for generating the whole pack.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        parent::handle();

        $this->whatResources();
        $this->controller();
        $this->request();
        $this->service();
        $this->repository();
        $this->model();
        $this->migration();
        $this->integrationTest();
    }

    /**
     * @return void
     */
    private function controller(): void
    {
        $controller = $this->askWithCompletion(
            'Do you want to create a controller? (yes/no)',
            ['yes', 'no'],
            'yes'
        );

        if ($controller !== 'yes') {
            return;
        }

        $this->call(
            'resource:generate:controller',
            [
                'name' => $this->attributeName,
                '--crud' => $this->isItCrud(),
                '--resources' => implode(',', $this->getResources())
            ]
        );
    }

    /**
     * @return void
     */
    private function service(): void
    {
        $service = $this->askWithCompletion(
            'Do you want to create a service? (yes/no)',
            ['yes', 'no'],
            'yes'
        );

        if ($service !== 'yes') {
            return;
        }

        $this->call(
            'resource:generate:service',
            [
                'name' => $this->attributeName,
                '--crud' => $this->isItCrud(),
                '--resources' => implode(',', $this->getResources())
            ]
        );
    }

    /**
     * @return void
     */
    private function repository(): void
    {
        $repository = $this->askWithCompletion(
            'Do you want to create a repository? (yes/no)',
            ['yes', 'no'],
            'yes'
        );

        if ($repository !== 'yes') {
            return;
        }

        $this->call(
            'resource:generate:repository',
            [
                'name' => $this->attributeName,
                '--crud' => $this->isItCrud(),
                '--resources' => implode(',', $this->getResources())
            ]
        );
    }

    /**
     * @return void
     */
    private function model(): void
    {
        $model = $this->askWithCompletion(
            'Do you want to create a model? (yes/no)',
            ['yes', 'no'],
            'yes'
        );

        if ($model !== 'yes') {
            return;
        }

        $this->call(
            'resource:generate:model',
            ['name' => $this->attributeName,]
        );
    }

    /**
     * @return void
     */
    private function integrationTest(): void
    {
        $test = $this->askWithCompletion(
            'Do you want to generate a basic integration test? (yes/no)',
            ['yes', 'no'],
            'yes'
        );

        if ($test !== 'yes') {
            return;
        }

        $this->call(
            'resource:generate:test',
            [
                'name' => $this->attributeName,
                '--crud' => $this->isItCrud()
            ]
        );
    }

    /**
     * @return void
     */
    private function migration(): void
    {
        $migration = $this->askWithCompletion(
            'Do you want to create a migration? (yes/no)',
            ['yes', 'no'],
            'yes'
        );

        if ($migration !== 'yes') {
            return;
        }

        $this->call(
            'make:migration',
            ['name' => 'create ' . $this->attributeLowPluralName]
        );

        $this->info('IMPORTANT: Do not forget to change ID too uuid in your migrations.');
        $this->info(
            'You can do so by removing the id row, and adding the following line: $table->uuid(\'id\')->primary();'
        );

        $this->deleteGitKeep('/database/migrations');
    }

    /**
     * @return void
     */
    private function request(): void
    {
        $request = $this->askWithCompletion(
            'Do you want to create a request? (yes/no)',
            ['yes', 'no'],
            'yes'
        );

        if ($request !== 'yes') {
            return;
        }

        $this->call(
            'resource:generate:request',
            [
                'name' => $this->attributeName,
                '--crud' => $this->isItCrud(),
                '--resources' => implode(',', $this->getResources())
            ]
        );
    }
}
