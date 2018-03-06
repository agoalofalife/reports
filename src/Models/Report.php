<?php
declare(strict_types=1);

namespace agoalofalife\Reports\Models;


use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['class_name', 'status', 'is_completed'];
}
