<?php

namespace Nj\BoltFieldExecutors\Fields\Processors;

use Nj\BoltFieldExecutors\Fields\Executors\SequenceExecutorOnFieldCollection;
use Nj\BoltFieldExecutors\Fields\Processors\Interfaces\FieldProcessorInterface;
use Nj\BoltFieldExecutors\Utils\Encryption\StringDecryptor;
use Bolt\Entity\Field;
use Bolt\Entity\FieldInterface;
use Exception;

/**
 *
 */
class AdminCredentialDecryptor implements FieldProcessorInterface
{
    /**
     * This field contains the type of the credential
     */
    const FIELD_NAME__FOR__TYPE = 'credential_type';
    private StringDecryptor $stringDecryptor;

    public function __construct(StringDecryptor $stringDecryptor)
    {
        $this->stringDecryptor = $stringDecryptor;
    }

    /**
     * @param FieldInterface $field
     * @return FieldInterface
     * @throws Exception
     */
    public function processField(FieldInterface $field): FieldInterface
    {
        $fieldsFilter = new FieldsFilter();
        $fieldsFilter->setExcludedFieldNames([self::FIELD_NAME__FOR__TYPE]);

        /** @var Field $field */
        $originalFields = (array)$field->getValue();

        $fieldNamesToDecrypt = $fieldsFilter->filterFieldNames($originalFields);

        foreach ($fieldNamesToDecrypt as $fieldName) {
            if (array_key_exists($fieldName, $originalFields)) {
                (new SequenceExecutorOnFieldCollection())
                    ->executeSequenceOnCollection([$originalFields[$fieldName]], [$this->stringDecryptor]);
            }
        }

        return $field;
    }
}
