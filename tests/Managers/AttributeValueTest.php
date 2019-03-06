<?php

namespace Railken\Amethyst\Tests\Managers;

use Railken\Amethyst\Fakers\AttributeValueFaker;
use Railken\Amethyst\Fakers\FooFaker;
use Railken\Amethyst\Managers\AttributeManager;
use Railken\Amethyst\Managers\AttributeValueManager;
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
            'schema' => 'email',
        ])->getResource();

        $attributable = $this->getManager()->createOrFail([
            'attributable_type' => Foo::class,
            'attributable_id'   => Foo::create(FooFaker::make()->parameters()->toArray())->id,
            'attribute_id'      => $attribute->id,
            'value'             => 'test@test.net',
        ])->getResource();

        $this->assertEquals('test@test.net', $attributable->value);
    }
}
