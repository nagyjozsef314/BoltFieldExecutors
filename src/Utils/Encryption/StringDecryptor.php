<?php
declare(strict_types=1);

namespace Nj\BoltFieldExecutors\Utils\Encryption;

use Nj\BoltFieldExecutors\Fields\Processors\Interfaces\FieldProcessorInterface;
use Bolt\Entity\Field;
use Bolt\Entity\FieldInterface;
use Exception;
use SodiumException;

/**
 *
 */
class StringDecryptor implements FieldProcessorInterface
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
    public function decryptString(FieldInterface $field): FieldInterface
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
        try {
            if (is_bool($field->getApiValue())) {
                return $field;
            }
            $field->setValue($this->encryptionHandler->decryptSecret($field->getApiValue()));
        } catch (Exception $exception) {
            throw new Exception(sprintf(
                "While decrypting field %s, with value &nbsp;%s&nbsp;, we've encountered the following error.\n%s",
                json_encode($field),
                json_encode($field->getApiValue()),
                $exception->getMessage()
            ));
        }
        return $field;
    }

}
