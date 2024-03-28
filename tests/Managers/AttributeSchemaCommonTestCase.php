<?php

namespace Amethyst\Tests\Managers;

use Amethyst\Fakers\FooFaker;
use Amethyst\Managers\AttributeSchemaManager;
use Amethyst\Managers\FooManager;
use Amethyst\Models\Foo;
use Amethyst\Tests\BaseTestCase;

abstract class AttributeSchemaCommonTestCase extends BaseTestCase
{
    public function resetFields()
    {
        \Amethyst\Models\AttributeSchema::all()->map(function ($i) {
            return $i->delete();
        });
    }

    public function commonField($name, $type, $valid = [], $invalid = [], $options = '', $delete = true)
    {
        $attribute = (new AttributeSchemaManager())->createOrFail([
            'name'    => $name,
            'schema'  => $type,
            'model'   => 'foo',
            'options' => $options,
        ])->getResource();
        $fooManager = new FooManager();

        $resources = [];

        foreach ($valid as $v) {
            $parameters = FooFaker::make()->parameters();
            $parameters->add(is_array($v) ? $v : [$name => $v]);
            
            $foo = $fooManager->createOrFail($parameters)->getResource();
            $foo->save();

            $foo = Foo::find($foo->id);

            $resources[] = $foo;

            if (is_array($v)) {
                foreach ($v as $k => $i) {
                    $this->assertEquals($i, $foo->toArray()[$k]);
                }
            } else {
                $this->assertEquals($v, $foo->toArray()[$name]);
            }
        }

        foreach ($invalid as $v) {
            $parameters = FooFaker::make()->parameters()
                ->set($name, $v);

            $result = $fooManager->create($parameters);

            $this->assertEquals(sprintf('FOO_%s_NOT_VALID', strtoupper($name)), $result->getSimpleErrors()[0]['code']);
        }

        return $resources;
    }
}
