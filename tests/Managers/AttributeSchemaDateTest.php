<?php

namespace Amethyst\Tests\Managers;

class AttributeSchemaDateTest extends AttributeSchemaCommonTest
{
    public function testBasicDate()
    {
        $this->resetFields();

        $this->commonField('date', 'Date', ['2010-10-10']);

        $this->resetFields();
    }
}
