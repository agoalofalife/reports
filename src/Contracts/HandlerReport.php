<?php
declare(strict_types=1);

namespace agoalofalife\Reports\Contracts;

use agoalofalife\Reports\Report;

interface HandlerReport
{
    public function handler($excel) : Report;
}