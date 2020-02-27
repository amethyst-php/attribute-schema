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

class AttributeSchemaTest extends BaseTest
{
    use TestableBaseTrait;

    /**
     * Manager class.
     *
     * @var string
     */
    protected $manager = AttributeSchemaManager::class;

    /**
     * Faker class.
     *
     * @var string
     */
    protected $faker = AttributeSchemaFaker::class;

    public function testDynamicAttributeSchema()
    {
        $attribute = (new AttributeSchemaManager())->createOrFail([
            'name'   => 'email',
            'schema' => 'Email',
            'model'  => 'foo',
        ])->getResource();

        $fooManager = new FooManager();
        $foo = $fooManager->createOrFail(FooFaker::make()->parameters())->getResource();
        $foo->fill(['email' => 'test@test.net']);
        $foo->save();

        $foo = Foo::find($foo->id);

        $this->assertEquals('test@test.net', $foo->email);

        $attribute->delete();
        $foo = Foo::find($foo->id);

        $this->assertEquals(true, empty($foo->email));
    }

    public function testEnumAttributeSchema()
    {
        $attribute = (new AttributeSchemaManager())->createOrFail([
            'name'    => 'select',
            'schema'  => 'Enum',
            'model'   => 'foo',
            'options' => Yaml::dump([
                'options' => [
                    1,
                    2,
                    3,
                ],
            ]),
        ])->getResource();

        $fooManager = new FooManager();
        $parameters = FooFaker::make()->parameters()
            ->set('select', 5);

        $result = $fooManager->create($parameters);
        $this->assertEquals('FOO_SELECT_NOT_VALID', $result->getSimpleErrors()[0]['code']);

        $parameters = FooFaker::make()->parameters()
            ->set('select', 3);

        $foo = $fooManager->createOrFail($parameters)->getResource();

        $foo = Foo::find($foo->id);

        $this->assertEquals(3, $foo->select);

        $attribute->delete();
        $foo = Foo::find($foo->id);

        $this->assertEquals(true, empty($foo->select));
    }
}
