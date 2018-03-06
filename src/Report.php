<?php
declare(strict_types=1);

namespace agoalofalife\Reports;

use agoalofalife\Reports\Contracts\ResourceCollectionReport;

abstract class Report implements ResourceCollectionReport
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
    abstract public function getFilename() : string;

    /**
     * Get title report
     * @return string
     */
    abstract public function getTitle() : string;

    /**
     * Get description report
     * @return string
     */
    abstract public function getDescription() : string;

    /**
     * @return array
     */
    public function toArray() : array
    {
        return [
            'name' => $this->getTitle(),
            'description' => $this->getDescription(),
            'class' => $this->getNameClass()
        ];
    }
    /**
     * Get full class name
     * @return string
     */
    private function getNameClass() : string
    {
        return get_class($this);
    }
}