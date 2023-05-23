<?php
declare(strict_types=1);

namespace Nj\BoltFieldExecutors\Utils\Encryption;

use Nj\BoltFieldExecutors\Fields\Processors\Interfaces\FieldProcessorInterface;
use Bolt\Entity\Field;
use Bolt\Entity\FieldInterface;
use SodiumException;

/**
 *
 */
class StringEncryptor implements FieldProcessorInterface
{
    private EncryptionHelper $encryptionHandler;

    /**
     * @param EncryptionHelper $encryptionHandler
     */
    public function __construct(EncryptionHelper $encryptionHandler)
    {
        $this->encryptionHandler = $encryptionHandler;
    }

    /**
     * @param FieldInterface $field
     * @return FieldInterface
     * @throws SodiumException
     */
    public function encryptString(FieldInterface $field): FieldInterface
    {
        return $this->processField($field);
    }

    /**
     * @param FieldInterface $field
     * @return FieldInterface
     * @throws SodiumException
     */
    public function processField(FieldInterface $field): FieldInterface
    {
        /** @var Field $field */
        if (is_bool($field->getApiValue())) {
            return $field;
        }

        $field->setValue(
            $this
                ->encryptionHandler
                ->encryptSecret((string)$field->getApiValue())
        );
        return $field;
    }

}
