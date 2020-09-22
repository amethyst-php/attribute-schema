<?php

namespace Amethyst\Tests\Managers;

use Symfony\Component\Yaml\Yaml;

class AttributeSchemaEnumTest extends AttributeSchemaCommonTest
{
    public function testBasicEnum()
    {
        $this->resetFields();

        $this->commonField('select', 'Enum', [1, 2, 3], [0, '3', 4], Yaml::dump([
            'options' => [
                1,
                2,
                3,
            ],
        ]));

        $this->resetFields();
    }
}
