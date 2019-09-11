<?php

namespace Empact\WebMonitor\Drivers;

interface DriverInterface
{
    /**
     * Search a given resource for the keyword
     *
     * @param string $keyword
     */
    public function search(string $keyword);
}
