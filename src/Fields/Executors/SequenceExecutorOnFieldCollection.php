<?php
declare(strict_types=1);

namespace Nj\BoltFieldExecutors\Fields\Executors;

use Nj\BoltFieldExecutors\Fields\Processors\Interfaces\FieldProcessorInterface;
use Nj\BoltFieldExecutors\Fields\Processors\Interfaces\SequenceExecutorOnFieldCollectionInterface;
use Bolt\Entity\Field\SetField;
use Bolt\Entity\FieldInterface;
use Exception;

/**
 * Executes a sequence of processes, over one item.
 */
class SequenceExecutorOnFieldCollection implements SequenceExecutorOnFieldCollectionInterface
{
    /**
     * @param iterable<FieldInterface> $fieldCollection
     * @param iterable<FieldProcessorInterface> $processSequence
     * @return void
     * @throws Exception
     */
    public function executeSequenceOnCollection(iterable $fieldCollection, iterable $processSequence): void
    {
        try {
            foreach ($fieldCollection as $field) {
                $this->executeProcessSequenceOnItem($field, $processSequence);
            }
        } catch (Exception $exception) {
            throw new Exception(
                sprintf("While executing process sequence on field %s, we've encountered an exception.\n%s",
                    json_encode($field),
                    $exception->getMessage()
                )
            );
        }
    }

    /**
     * @param FieldInterface $field
     * @param iterable<FieldProcessorInterface> $processSequence
     * @return void
     * @throws Exception
     */
    public function executeProcessSequenceOnItem(FieldInterface $field, iterable $processSequence): void
    {
        try {
            (new SequenceExecutorOnField())->executeSequenceOnField($processSequence, $field);
        } catch (Exception $exception) {
            throw new Exception(
                sprintf(
                    "While processing sequence on field %s, we have encountered the following exception:\n%s",
                    json_encode($field),
                    $exception->getMessage()
                )
            );
        }
    }
}
