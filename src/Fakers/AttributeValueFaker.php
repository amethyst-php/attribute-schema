<?php

namespace Railken\Amethyst\Fakers;

use Faker\Factory;
use Railken\Bag;
use Railken\Lem\Faker;

class AttributeValueFaker extends Faker
{
    /**
     * @return \Railken\Bag
     */
    public function parameters()
    {
        $faker = Factory::create();

        $bag = new Bag();
        $bag->set('attribute', AttributeFaker::make()->parameters()->toArray());
        $bag->set('value', 5);
        $bag->set('attributable_type', 'foo');
        $bag->set('attributable', FooFaker::make()->parameters()->toArray());

        return $bag;
    }
}
