<?php
declare(strict_types=1);

namespace agoalofalife\Reports\Console;


use Illuminate\Console\GeneratorCommand;

class ReportMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Report class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Report';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/report.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Reports';
    }
}