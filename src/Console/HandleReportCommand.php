<?php
declare(strict_types=1);

namespace agoalofalife\Reports\Console;

use agoalofalife\Reports\Report;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class HandleReportCommand
 * @package agoalofalife\Reports\Console
 */
class HandleReportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:handle {classReport}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handle Report class and save file';

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Exception
     */
    public function handle() : void
    {
        $classReport = $this->argument('classReport');

        if (class_exists($classReport) === false) {
             throw new \Exception($classReport . ' class not exist');
        }

        if (is_subclass_of($classReport, Report::class) === false) {
            throw new \Exception($classReport . ' class is not subclass ' . Report::class);
        }

        $report = app()->make($classReport);
//        dd($report->handler('s'));
        Excel::create($report->getFileName(), [$report, 'handler'])->store('xls', storage_path('excel/exports'));
    }
}