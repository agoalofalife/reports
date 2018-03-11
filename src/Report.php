<?php
declare(strict_types=1);

namespace agoalofalife\Reports;

use agoalofalife\Reports\Contracts\ResourceCollectionReport;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use \agoalofalife\Reports\Models\Report as ReportBase;

/**
 * Class Report
 * @package agoalofalife\Reports
 */
abstract class Report implements ResourceCollectionReport
{
    /**
     * Status report
     * @var string
     */
    protected $status = ReportBase::STATUS_NEW;

    /**
     * Flag update report and not read
     * @var bool
     */
    protected $isCompleted = false;

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
            'path' => $this->getPathToFile(),
            'lastModified' => $this->getDateLastModified(),
            'isCompleted' => $this->isCompleted,
            'status' => $this->status
        ];
    }

    /**
     * Get path to file
     * @return null|string
     */
    public function getPathToFile() : ?string
    {
        return Storage::disk($this->disk)->exists($this->getFileNormalize()) ?
            Storage::disk($this->disk)->url($this->getFileNormalize()) : null;
    }

    /**
     * Get date last modified file
     * @return null|string
     */
    public function getDateLastModified() : ?string
    {
        return Storage::disk($this->disk)->exists($this->getFileNormalize()) ?
            date('Y-m-d H:i:s', Storage::disk($this->disk)->lastModified($this->getFileNormalize())) : null;
    }
    /**
     * Get full class name
     * @return string
     */
    public function getNameClass() : string
    {
        return get_class($this);
    }

    /**
     * Change is completed
     * @param bool $flag
     */
    public function changeCompleted(bool $flag) : void
    {
        $this->isCompleted = $flag;
    }

    /**
     * @return bool
     */
    public function getCompleted() : bool
    {
        return $this->isCompleted;
    }
    /**
     * Change status state report
     * @param string $status
     */
    public function changeStatus(string $status) : void
    {
        $this->status = $status;
    }

    /**
     * Get Model Report
     * @return Model
     */
    public function getReportModel() : Model
    {
        return ReportBase::where('class_name', get_class($this))->get()->first();
    }
    /**
     * Get builder two parts string :
     * Filename
     * Extension
     * @return string
     */
    public function getFileNormalize() : string
    {
        return "{$this->getFilename()}.{$this->extension}";
    }
}