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

class AttributeSchemaDataNameTest extends AttributeSchemaCommonTest
{
    public function testBasicDate()
    {
        $this->resetFields();
        
        $this->commonField('data', 'DataName', ['foo'], ['invalidName']);
        
        $this->resetFields();
    }
}