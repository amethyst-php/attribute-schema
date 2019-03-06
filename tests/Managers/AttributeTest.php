<?php

namespace Railken\Amethyst\Tests\Managers;

use Railken\Amethyst\Fakers\AttributeFaker;
use Railken\Amethyst\Managers\AttributeManager;
use Railken\Amethyst\Tests\BaseTest;
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
}
