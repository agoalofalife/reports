<?php
declare(strict_types=1);

namespace agoalofalife\Reports\Models;


use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    const STATUS_ERROR = 'error';
    const STATUS_PROCESS = 'process';
    const STATUS_COMPLETED = 'completed';
    const STATUS_NEW = 'new';
    const STATUS_WORKER = 'worker';

    protected $fillable = ['class_name', 'status', 'is_completed', 'pid'];
}
