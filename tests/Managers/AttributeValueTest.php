<?php

namespace Amethyst\Tests\Managers;

use Amethyst\Fakers\AttributeValueFaker;
use Amethyst\Fakers\FooFaker;
use Amethyst\Managers\AttributableManager;
use Amethyst\Managers\AttributeManager;
use Amethyst\Managers\AttributeValueManager;
use Amethyst\Managers\FooManager;
use Amethyst\Models\Foo;
use Amethyst\Tests\BaseTest;
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
