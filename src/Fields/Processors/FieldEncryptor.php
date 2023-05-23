<?php

namespace Nj\BoltFieldExecutors\Fields\Processors;

use Bolt\Entity\FieldInterface;
use Symfony\Component\VarDumper\VarDumper;

class FieldEncryptor implements \Nj\BoltFieldExecutors\Fields\Processors\Interfaces\FieldProcessorInterface
{

    public function processField(FieldInterface $field): FieldInterface
    {
        // TODO: Implement processFieldUsingProcessor() method.
        VarDumper::dump($field);
        return $field;
    }
}
