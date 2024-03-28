<?php

namespace Amethyst\Tests\Managers;

use Amethyst\Fakers\FooFaker;
use Amethyst\Managers\AttributeSchemaManager;
use Amethyst\Managers\FooManager;

class AttributeSchemaRequiredTest extends AttributeSchemaCommonTestCase
{
    public function testRequired()
    {
        $this->resetFields();

        $attribute = (new AttributeSchemaManager())->createOrFail([
            'name'     => 'field_required',
            'schema'   => 'Number',
            'model'    => 'foo',
            'required' => true,
        ])->getResource();

        $fooManager = new FooManager();

        $parameters = FooFaker::make()->parameters();
        $result = $fooManager->create($parameters);

        $this->assertEquals('FOO_FIELD_REQUIRED_NOT_DEFINED', $result->getSimpleErrors()[0]['code']);

        $this->resetFields();
    }
}
