<?php
declare(strict_types=1);

namespace agoalofalife\Reports\Console;

use agoalofalife\Reports\Report;
use agoalofalife\Reports\Models\Report as ReportModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
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
        $excelWriter = Excel::create($report->getFileName(), $resultHandler = [$report, 'handler']);
        // if method handler return true, meaning 'success' result
        if ($resultHandler) {
            $excelWriter->store($report->format, Storage::disk($report->disk)
                ->getDriver()->getAdapter()->getPathPrefix());

            $report->getReportModel()->update([
                'status' => ReportModel::STATUS_COMPLETED,
                'is_completed' => true,
            ]);
        }
    }
}