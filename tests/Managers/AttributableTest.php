<?php

namespace Amethyst\Tests\Managers;

use Amethyst\Fakers\AttributableFaker;
use Amethyst\Managers\AttributableManager;
use Amethyst\Tests\BaseTest;
use Railken\Lem\Support\Testing\TestableBaseTrait;

class AttributableTest extends BaseTest
{
    use TestableBaseTrait;

    /**
     * Manager class.
     *
     * @var string
     */
    protected $manager = AttributableManager::class;

    /**
     * Faker class.
     *
     * @var string
     */
    protected $faker = AttributableFaker::class;
}
