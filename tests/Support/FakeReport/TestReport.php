<?php
declare(strict_types=1);

namespace agoalofalife\Tests\Support\FakeReport;

use agoalofalife\Reports\Contracts\HandlerReport;
use agoalofalife\Reports\Report;

/**
 * Class TestReport
 * @package App\Reports
 */
class TestReport extends Report implements HandlerReport
{
    /**
     * Disk for filesystem
     * @var string
     */
    public $disk = 'public';

    /**
     * Format export : xls, xlsx, pdf, csv
     * @var string
     */
    public $extension = 'xlsx';

     /**
     * Get file name
     * @return string
     */
    public function getFilename() : string
    {
        return 'TestReport';
    }

    /**
     * Get title report
     * @return string
     */
    public function getTitle() : string
    {
        return 'TestReport';
    }

    /**
     * Get description report
     * @return string
     */
    public function getDescription() : string
    {
        return 'Report is test';
    }

    /**
     * @link full documentation https://laravel-excel.maatwebsite.nl
     * @param $excel
     * @return bool
     */
    public function handler($excel): bool
    {
        $excel->sheet('Sheetname', function ($sheet) {
            $sheet->fromArray(array(
                array('data1', 'data2'),
                array('data3', 'data4')
            ));
        });

        return true;
    }
}
