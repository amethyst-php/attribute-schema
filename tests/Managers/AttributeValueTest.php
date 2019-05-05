<?php

namespace Railken\Amethyst\Tests\Managers;

use Railken\Amethyst\Fakers\AttributeValueFaker;
use Railken\Amethyst\Fakers\FooFaker;
use Railken\Amethyst\Managers\AttributableManager;
use Railken\Amethyst\Managers\AttributeManager;
use Railken\Amethyst\Managers\AttributeValueManager;
use Railken\Amethyst\Managers\FooManager;
use Railken\Amethyst\Models\Foo;
use Railken\Amethyst\Tests\BaseTest;
use Railken\Lem\Support\Testing\TestableBaseTrait;

class AttributeValueTest extends BaseTest
{
    use TestableBaseTrait;

    /**
     * Manager class.
     *
     * @var string
     */
    protected $manager = AttributeValueManager::class;

    /**
     * Faker class.
     *
     * @var string
     */
    protected $faker = AttributeValueFaker::class;

    public function testDynamicAttribute()
    {
        $attribute = (new AttributeManager())->createOrFail([
            'name'   => 'email',
            'schema' => 'Email',
        ])->getResource();

        (new AttributableManager())->createOrFail([
            'attribute_id'      => $attribute->id,
            'attributable_type' => 'foo',
        ])->getResource();

        $fooManager = new FooManager();
        $foo = $fooManager->createOrFail(FooFaker::make()->parameters())->getResource();

        $this->assertEquals(true, $foo->attrs()->has('email'));

        $attributable = $this->getManager()->createOrFail([
            'attributable_type' => 'foo',
            'attributable_id'   => $foo->id,
            'attribute_id'      => $attribute->id,
            'value'             => 'test@test.net',
        ])->getResource();

        $this->assertEquals('test@test.net', $attributable->value);

        $attributable = (new AttributableManager())->createOrFail([
            'attributable_type' => 'foo',
            'attribute_id'      => $attribute->id,
        ])->getResource();

        // Reboot manager fooManager...
        $fooManager = new FooManager();

        $fooManager->update($foo, [
            'attrs' => [
                $attribute->name => 'test2@test.net',
            ],
        ]);

        $this->assertEquals('test2@test.net', $foo->attrs()->email);
        $this->assertEquals('test2@test.net', $fooManager->getSerializer()->serialize($foo)->get('attrs.email'));

        $foo = Foo::find($foo->id);

        $this->assertEquals('test2@test.net', $foo->attrs()->email);
        $this->assertEquals('test2@test.net', $fooManager->getSerializer()->serialize($foo)->get('attrs.email'));
    }
}
