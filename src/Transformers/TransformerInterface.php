<?php

namespace Empact\WebMonitor\Transformers;

interface TransformerInterface
{
    /**
     * Transforms the given data into the template
     * data
     *
     * @return array
     */
    public function transform();
}
