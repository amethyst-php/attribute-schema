<?php

namespace Amethyst\Tests\Managers;

use Amethyst\Fakers\AttributeSchemaFaker;
use Amethyst\Fakers\FooFaker;
use Amethyst\Managers\AttributeSchemaManager;
use Amethyst\Managers\FooManager;
use Amethyst\Models\Foo;
use Amethyst\Tests\BaseTest;
use Railken\Lem\Support\Testing\TestableBaseTrait;
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
