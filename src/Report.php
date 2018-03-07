<?php
declare(strict_types=1);

namespace agoalofalife\Reports;

use agoalofalife\Reports\Contracts\ResourceCollectionReport;
use Illuminate\Support\Facades\Storage;

/**
 * Class Report
 * @package agoalofalife\Reports
 */
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
            'class' => $this->getNameClass(),
            'path' => Storage::disk($this->disk)->exists($this->getFilename()) ?
                Storage::disk($this->disk)->get($this->getFilename())->url() : null
        ];
    }
    /**
     * Get full class name
     * @return string
     */
    public function getNameClass() : string
    {
        return get_class($this);
    }
}