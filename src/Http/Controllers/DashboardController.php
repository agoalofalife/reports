<?php
declare(strict_types=1);

namespace agoalofalife\Reports\Http\Controllers;

use agoalofalife\Reports\Http\Resources\ReportsCollection;
use agoalofalife\Reports\Models\Report;
use App\Reports\TestReport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\ProcessUtils;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class DashboardController extends Controller
{
    /**
     * Get table columns
     * @return \Illuminate\Http\JsonResponse
     */
    public function tableColumn() : JsonResponse
    {
        return response()->json(trans("reports::dashboard"));
    }

    /**
     * Get list reports
     * @return JsonResponse
     */
    public function getReports() : JsonResponse
    {
        $reports = collect(config('reports.reports'))->map(function (string $classReport) {
            $report = new $classReport;
            $reportDatabase = Report::firstOrCreate(
                [
                    'class_name' => $report->getNameClass()
                ]
            );
            $reportDatabase->is_completed ? $report->changeCompleted(true) : false;
            $report->changeStatus($reportDatabase->status);
            return $report;
        });
        return (new ReportsCollection($reports))->response();
    }

    /**
     * Get count not read reports
     * @return JsonResponse
     */
    public function getNotificationCount() : JsonResponse
    {
        return response()->json(['data' => [
            'count' => Report::where('is_completed', true)->get()->count()
        ]]);
    }

    /**
     * Update report
     * @param Request $request
     */
    public function updateReport(Request $request)
    {
//        $report = Report::where('class_name', $request->class)->get()->first();
//        $report->update([
//           'status' => Report::STATUS_PROCESS
//        ]);
//        $report = app()->make($report->class_name);
//        dd($report->handler()->storage());
        dd(ProcessUtils::escapeArgument(TestReport::class));

        $process = new Process('php ../artisan reports:handle  App\\\Reports\\\TestReport');
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
       dd($process->getOutput());

    }
}