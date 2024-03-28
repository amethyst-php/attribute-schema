<?php

namespace Amethyst\Tests\Managers;

class AttributeSchemaTextTest extends AttributeSchemaCommonTestCase
{
    public function testBasicText()
    {
        $this->resetFields();

        $this->commonField('text', 'Text', ['Ah yes, a text']);

        $this->resetFields();
    }
}
