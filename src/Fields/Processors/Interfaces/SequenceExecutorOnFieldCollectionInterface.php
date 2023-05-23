<?php

namespace Nj\BoltFieldExecutors\Fields\Processors\Interfaces;

use Bolt\Entity\FieldInterface;

interface SequenceExecutorOnFieldCollectionInterface
{
    /**
     * @param iterable<FieldInterface> $fieldCollection
     * @param iterable<FieldProcessorInterface> $processSequence
     * @return void
     */
    public function executeSequenceOnCollection(iterable $fieldCollection, iterable $processSequence): void;
}
