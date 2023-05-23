<?php

namespace Nj\BoltFieldExecutors\Fields\Executors;

use Nj\BoltFieldExecutors\Fields\Processors\Interfaces\FieldProcessorInterface;
use Nj\BoltFieldExecutors\Fields\Processors\Interfaces\SequenceExecutorOnFieldInterface;
use Bolt\Entity\FieldInterface;
use Exception;


/**
 * Executes a sequence of processes, over one field.
 */
class SequenceExecutorOnField implements SequenceExecutorOnFieldInterface
{
    /**
     * @param FieldInterface $field
     * @param iterable<FieldProcessorInterface> $processSequence
     * @return void
     * @throws Exception
     */
    public function executeSequenceOnField(iterable $processSequence, FieldInterface $field): void
    {
        try {
            foreach ($processSequence as $processorItem) {
                $this->processFieldUsingProcessor($field, $processorItem);
            }
        } catch (Exception $exception) {
            throw new Exception(
                sprintf(
                    "While processing field %s, processorItem encountered following exception:\n%s",
                    json_encode($field),
                    $exception->getMessage()
                )
            );
        }
    }

    /**
     * @param FieldInterface $field
     * @param FieldProcessorInterface $processor
     * @return void
     * @throws Exception
     */
    private function processFieldUsingProcessor(FieldInterface $field, FieldProcessorInterface $processor): void
    {
        try {
            call_user_func([$processor, 'processField'], $field);
        } catch (Exception $exception) {
            throw new Exception(
                sprintf(
                    "Exception encountered, while processing field %s, using processor: %s \n%s",
                    json_encode($field),
                    get_class($processor) . '::processField()',
                    $exception->getMessage()
                )
            );
        }
    }
}
