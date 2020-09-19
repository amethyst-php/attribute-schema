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

class AttributeSchemaDateTimeTest extends AttributeSchemaCommonTest
{
    public function testBasicDateTime()
    {
        $this->commonField('datetime', 'DateTime', ['2010-10-10 10:20:40'], ['not date']);
    }
}
