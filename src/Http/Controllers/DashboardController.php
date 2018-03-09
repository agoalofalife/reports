<?php
declare(strict_types=1);

namespace agoalofalife\Reports\Http\Controllers;

use agoalofalife\Reports\Http\Resources\ReportsCollection;
use agoalofalife\Reports\Models\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

/**
 * Class DashboardController
 * @package agoalofalife\Reports\Http\Controllers
 */
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
                ],
                [
                    'class_name' => $report->getNameClass()
                ]
            );
            $reportDatabase->is_completed ? $report->changeCompleted(true) : false;
            $report->changeStatus($reportDatabase->status ?? Report::STATUS_NEW);
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
     * @return JsonResponse
     */
    public function updateReport(Request $request) : JsonResponse
    {
        $report = Report::where('class_name', $request->class)->get()->first();
        $report->update([
           'status' => Report::STATUS_PROCESS
        ]);
        return response()->json(['data' => [
            'status' => 'success'
        ]]);
    }

    /**
     * @param string $className
     * @return mixed
     */
    public function downloadFile(string $className)
    {
        $className = str_replace('@', '\\', $className);
        if (class_exists($className)) {
            $report = app()->make($className);
            $report->getReportModel()->update([
                'is_completed' => false
            ]);
            return Storage::disk($report->disk)->download($report->getFileNormalize());
        }
        return response('Class not exist', 500);
    }
}