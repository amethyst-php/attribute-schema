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

class AttributeSchemaNumberTest extends AttributeSchemaCommonTest
{
    public function testBasicNumber()
    {
        $this->commonField('number', 'Number', ['5', 10, 1e5, 30.50, "39.28"], ['not number', '38,38']);
    }
}
