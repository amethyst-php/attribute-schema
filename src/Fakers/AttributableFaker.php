<?php

namespace Railken\Amethyst\Fakers;

use Faker\Factory;
use Railken\Bag;
use Railken\Lem\Faker;

class AttributableFaker extends Faker
{
    /**
     * @return \Railken\Bag
     */
    public function parameters()
    {
        $faker = Factory::create();

        $bag = new Bag();
        $bag->set('attribute', AttributeFaker::make()->parameters()->toArray());
        $bag->set('attributable_type', \Railken\Amethyst\Models\Foo::class);

        return $bag;
    }
}
