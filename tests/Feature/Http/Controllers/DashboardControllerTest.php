<?php
declare(strict_types=1);

namespace agoalofalife\Tests\Feature\Http\Controllers;

use agoalofalife\Reports\Models\Report;
use agoalofalife\Tests\Support\FakeReport\TestReport;
use agoalofalife\Tests\TestCase;

/**
 * Class DashboardControllerTest
 * @package agoalofalife\Tests\Feature\Http\Controllers
 */
class DashboardControllerTest extends TestCase
{
    protected $fakeReportClass = TestReport::class;

    public function testTableColumnLocalEn() : void
    {
        $this->get('reports/api/dashboard.table.column')
            ->assertJson(trans("reports::dashboard"));
    }

    public function testGetReportsIsEmpty() : void
    {
        $this->get('reports/api/dashboard.reports')->assertJson([
            'data' => []
        ]);
    }

    public function testGetReports() : void
    {
        config(['reports.reports' => [
            $this->fakeReportClass
        ]]);
        $report = app()->make($this->fakeReportClass);

        $this->get('reports/api/dashboard.reports')->assertJson([
            'data' => [
            [
                  "name" => $report->getTitle(),
                  "description" => $report->getDescription(),
                  "class" => $this->fakeReportClass,
                  "path" => null,
                  "lastModified" => null,
                  "isCompleted" => false,
                  "status" => Report::STATUS_NEW,
            ]
            ]
        ]);
    }

    public function testGetNotificationCountZero() : void
    {
        $this->get('reports/api/dashboard.reports.notificationCount')->assertJson([
            'data' => [
                'count' => 0
            ]
        ]);
    }

    public function testGetNotificationCountIsNotZero() : void
    {
        $randomInt = $this->faker()->randomDigit;
        factory(Report::class, $randomInt)->create([
           'is_completed' => true
        ]);

        $this->get('reports/api/dashboard.reports.notificationCount')->assertJson([
            'data' => [
                'count' => $randomInt
            ]
        ]);
    }
}