<?php
declare(strict_types=1);
namespace agoalofalife\Reports\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class ReportsCollection
 * @package agoalofalife\Reports\Http\Resources
 */
class ReportsCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        // TODO add reports merge with database info
        return parent::toArray($request);
    }
}