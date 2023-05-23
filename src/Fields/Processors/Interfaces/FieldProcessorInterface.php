<?php

namespace Nj\BoltFieldExecutors\Fields\Processors\Interfaces;

use Bolt\Entity\FieldInterface;

/**
 *
 */
interface FieldProcessorInterface
{
    public function processField(FieldInterface $field): FieldInterface;
}
