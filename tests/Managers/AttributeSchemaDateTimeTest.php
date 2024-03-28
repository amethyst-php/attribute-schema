<?php

namespace Amethyst\Tests\Managers;

class AttributeSchemaDateTimeTest extends AttributeSchemaCommonTestCase
{
    public function testBasicDateTime()
    {
        $this->resetFields();

        $this->commonField('datetime', 'DateTime', ['2010-10-10 10:20:40'], ['not date']);

        $this->resetFields();
    }
}
