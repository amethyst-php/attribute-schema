<?php

namespace Amethyst\Tests\Managers;

use Amethyst\Fakers\FooFaker;
use Amethyst\Managers\FooManager;
use Symfony\Component\Yaml\Yaml;

class AttributeSchemaBelongsToTest extends AttributeSchemaCommonTestCase
{
    public function testBasicBelongsTo()
    {
        $this->resetFields();

        $fooManager = new FooManager();
        $foo = $fooManager->createOrFail(FooFaker::make()->parameters())->getResource();

        $this->commonField('parent_id', 'BelongsTo', [$foo->id], [999], Yaml::dump([
            'relationName' => 'parent',
            'relationData' => 'foo',
        ]));

        $this->resetFields();
    }
}
