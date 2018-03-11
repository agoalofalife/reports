<?php
declare(strict_types=1);

namespace agoalofalife\Tests\Unit;

use agoalofalife\Tests\TestCase;
use agoalofalife\Tests\Support\FakeReport\TestReport;

class ReportTest extends TestCase
{
    public function testChangeCompleted() : void
    {
        $report = new TestReport();
        $report->changeCompleted(true);

        $this->assertTrue($report->getCompleted());
    }
}
