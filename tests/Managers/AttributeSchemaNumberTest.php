<?php

namespace Amethyst\Tests\Managers;

class AttributeSchemaNumberTest extends AttributeSchemaCommonTestCase
{
    public function testBasicNumber()
    {
        $this->resetFields();

        $this->commonField('number', 'Number', ['5', 10, 1e5, 30.50, '39.28'], ['not number', '38,38']);

        $this->resetFields();
    }
}
