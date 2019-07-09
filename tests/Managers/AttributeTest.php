<?php

namespace Amethyst\Tests\Managers;

use Amethyst\Fakers\AttributeFaker;
use Amethyst\Managers\AttributeManager;
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
}
