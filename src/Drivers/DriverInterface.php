<?php

namespace Empact\WebMonitor\Drivers;

interface DriverInterface
{
    /**
     * @return array
     */
    public function search(string $keyword);
}
