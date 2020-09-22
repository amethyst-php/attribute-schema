<?php

namespace Amethyst\Tests\Managers;

class AttributeSchemaEmailTest extends AttributeSchemaCommonTest
{
    public function testBasicEmail()
    {
        $this->resetFields();

        $this->commonField('email', 'Email', ['test@test.net'], ['not_email']);

        $this->resetFields();
    }
}
