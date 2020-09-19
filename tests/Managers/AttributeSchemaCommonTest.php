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

abstract class AttributeSchemaCommonTest extends BaseTest
{
    public function commonField($name, $type, $valid = [], $invalid = [], $options = '')
    {
        $attribute = (new AttributeSchemaManager())->createOrFail([
            'name'   => $name,
            'schema' => $type,
            'model'  => 'foo',
            'options' => $options
        ])->getResource();
        $fooManager = new FooManager();

        foreach ($valid as $v) {
            $foo = $fooManager->createOrFail(FooFaker::make()->parameters())->getResource();
            $foo->fill([$name => $v]);
            $foo->save();

            $foo = Foo::find($foo->id);
            
            $this->assertEquals($v, $foo->toArray()[$name]);
        }

        foreach ($invalid as $v) {

            $parameters = FooFaker::make()->parameters()
                ->set($name, $v);

            $result = $fooManager->create($parameters);

            $this->assertEquals(sprintf('FOO_%s_NOT_VALID', strtoupper($name)), $result->getSimpleErrors()[0]['code']);
        }

        $attribute->delete();
        $foo = Foo::find($foo->id);

        $this->assertEquals(true, empty($foo->$name));
    }
}
