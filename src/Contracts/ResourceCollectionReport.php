<?php
declare(strict_types=1);

namespace agoalofalife\Reports\Contracts;

interface ResourceCollectionReport
{
    public function toArray() : array;
}