<?php

namespace Amethyst\Tests\Managers;

use Amethyst\Fakers\AttributeFaker;
use Amethyst\Fakers\FooFaker;
use Amethyst\Managers\AttributeManager;
use Amethyst\Managers\FooManager;
use Amethyst\Models\Foo;
use Amethyst\Tests\BaseTest;
use Railken\Lem\Support\Testing\TestableBaseTrait;

class AttributeTest extends BaseTest
{
    use TestableBaseTrait;

    /**
     * Manager class.
     *
     * @var string
     */
    protected $manager = AttributeManager::class;

    /**
     * Faker class.
     *
     * @var string
     */
    protected $faker = AttributeFaker::class;

    public function testDynamicAttribute()
    {
        $attribute = (new AttributeManager())->createOrFail([
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
}
