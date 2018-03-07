<?php
declare(strict_types=1);

namespace agoalofalife\Reports\Contracts;

/**
 * Interface StorageReport
 * @package agoalofalife\Reports\Contracts
 */
interface StorageReport
{
    /**
     * Method save file
     * @return mixed
     */
    public function storage();
}