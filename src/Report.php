<?php
declare(strict_types=1);

namespace agoalofalife\Reports;


abstract class Report
{
    /**
     * Disk for filesystem
     * @var string
     */
    protected $disk = 'public';

    /**
     * Get file name
     * @return string
     */
    abstract function getFilename() : string;

    /**
     * Get title report
     * @return string
     */
    abstract function getTitle() : string;

    /**
     * Get description report
     * @return string
     */
    abstract function getDescription() : string;

}