<?php

namespace Empact\WebMonitor\Drivers;

interface DriverInterface
{
    /**
     * Initiate query params
     *
     * @param array $query
     * @return $this
     */
    public function init(array $query);

    /**
     * Search a given resource for the keyword
     *
     * @return mixed
     */
    public function search();
}
