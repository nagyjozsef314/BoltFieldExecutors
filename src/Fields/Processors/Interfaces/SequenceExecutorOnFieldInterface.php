<?php

namespace Nj\BoltFieldExecutors\Fields\Processors\Interfaces;

use Bolt\Entity\FieldInterface;

interface SequenceExecutorOnFieldInterface
{
    /**
     * @param iterable<FieldProcessorInterface> $processSequence
     * @param FieldInterface $field
     * @return void
     */
    public function executeSequenceOnField(iterable $processSequence, FieldInterface $field): void;
}
