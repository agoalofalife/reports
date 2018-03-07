<?php
declare(strict_types=1);

namespace agoalofalife\Reports\Http\Controllers;

use agoalofalife\Reports\Http\Resources\ReportsCollection;
use agoalofalife\Reports\Models\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

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
        $reports = collect(config('reports.reports'))->map(function ($classReport) {
            return new $classReport;
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
}