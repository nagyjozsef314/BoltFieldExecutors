<?php

namespace Nj\BoltFieldExecutors\Fields\Processors;

/**
 *
 */
class FieldsFilter
{
    /**
     * @var iterable<string>
     */
    private iterable $excludedFieldNames;

    /**
     * @param iterable<string> $excludedFieldNames
     */
    public function setExcludedFieldNames(iterable $excludedFieldNames): void
    {
        $this->excludedFieldNames = $excludedFieldNames;
    }

    /**
     * @return iterable<string>
     */
    public function getExcludedFieldNames(): iterable
    {
        return $this->excludedFieldNames;
    }

    /**
     *
     * @param iterable<string> $allFieldNamesList
     * @return iterable<string>
     */
    public function filterFieldNames(iterable $allFieldNamesList): iterable
    {
        $allFieldNames = array_keys((array)$allFieldNamesList);

        foreach ($this->excludedFieldNames as $excludedFieldName) {

            $elementIndex = array_search($excludedFieldName, $allFieldNames, true);

            if (false !== $elementIndex) {
                unset($allFieldNames[$elementIndex]);
            }
        }
        return $allFieldNames;
    }

}
