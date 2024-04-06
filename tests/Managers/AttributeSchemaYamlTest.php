<?php

namespace Amethyst\Tests\Managers;

class AttributeSchemaYamlTest extends AttributeSchemaCommonTestCase
{
    public function testBasicYaml()
    {
        $this->resetFields();

        $this->commonField('yaml', 'Yaml', ["valid:yaml"]);

        $this->resetFields();
    }
}
