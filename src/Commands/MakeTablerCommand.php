<?php

namespace bytemorphic\Tabler\Commands;

use Illuminate\Console\GeneratorCommand;
use InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;

class MakeTablerCommand extends GeneratorCommand
{
    protected $name = 'make:tabler';

    protected $description = 'Create a new Tabler class';

    protected $type = 'Tabler';

    protected function getStub()
    {
        return __DIR__.'/stubs/tabler.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Tabler';
    }

    protected function buildClass($name)
    {
        $replace = [];

        $replace = $this->buildModelReplacements($replace);

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }

    protected function buildModelReplacements(array $replace)
    {
        $modelClass = $this->parseModel($this->option('model'));

        return array_merge($replace, [
            '{{ modelClass }}' => $modelClass,
            '{{ modelVariable }}' => lcfirst(class_basename($modelClass)),
        ]);
    }

    // protected function parseModel($model)
    // {
    //     if (is_null($model)) {
    //         return 'App\Models\User';
    //     }

    //     if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
    //         throw new InvalidArgumentException('Model name contains invalid characters.');
    //     }

    //     return $this->qualifyModel($model);
    // }

    protected function parseModel($model)
{
    if (is_null($model)) {
        $this->error('Please specify a model using the --model option. Example:');
        $this->line('php artisan make:tabler PostTabler --model=Post');
        exit(1); // Stop execution
    }

    if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
        throw new InvalidArgumentException('Model name contains invalid characters.');
    }

    return $this->qualifyModel($model);
}


    protected function getOptions()
    {
        return [
            ['model', 'm', InputArgument::OPTIONAL, 'The model that the tabler applies to'],
        ];
    }
}
