<?php

namespace Amethyst\Tests\Managers;

class AttributeSchemaDataNameTest extends AttributeSchemaCommonTest
{
    public function testBasicDate()
    {
        $this->resetFields();

        $this->commonField('data', 'DataName', ['foo'], ['invalidName']);

        $this->resetFields();
    }
}
