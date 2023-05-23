<?php

namespace Nj\BoltFieldExecutors\Fields\Processors;

use Nj\BoltFieldExecutors\Fields\Executors\SequenceExecutorOnFieldCollection;
use Nj\BoltFieldExecutors\Fields\Processors\Interfaces\FieldProcessorInterface;
use Nj\BoltFieldExecutors\Utils\Encryption\StringEncryptor;
use Bolt\Entity\Field;
use Bolt\Entity\FieldInterface;
use Exception;

/**
 *
 */
class AdminCredentialEncryptor implements FieldProcessorInterface
{
    /**
     * This field contains the type of the credential
     */
    const FIELD_NAME__FOR__TYPE = 'credential_type';
    private StringEncryptor $stringEncryptor;

    public function __construct(StringEncryptor $stringEncryptor)
    {
        $this->stringEncryptor = $stringEncryptor;
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

        $fieldNamesToEncrypt = $fieldsFilter->filterFieldNames($originalFields);

        foreach ($fieldNamesToEncrypt as $fieldName) {
            if (array_key_exists($fieldName, $originalFields)) {
                (new SequenceExecutorOnFieldCollection())
                    ->executeSequenceOnCollection([$originalFields[$fieldName]], [$this->stringEncryptor]);
            }
        }

        return $field;
    }
}
