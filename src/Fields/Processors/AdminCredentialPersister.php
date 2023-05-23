<?php

namespace Nj\BoltFieldExecutors\Fields\Processors;

use Nj\BoltFieldExecutors\Fields\Processors\Interfaces\FieldProcessorInterface;
use Bolt\Entity\FieldInterface;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

/**
 *
 */
class AdminCredentialPersister implements FieldProcessorInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param FieldInterface $field
     * @return FieldInterface
     * @throws Exception
     */
    public function processField(FieldInterface $field): FieldInterface
    {
        try {
            $this->entityManager->persist($field);
            $this->entityManager->flush();
        } catch (Exception $exception) {
            throw new Exception(
                sprintf(
                    "An exception has occurred during persisting field %s.\nThe original message is: %s.",
                    json_encode($field),
                    $exception->getMessage()
                )
            );
        }
        return $field;
    }
}
