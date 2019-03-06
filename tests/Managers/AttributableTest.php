<?php

namespace Railken\Amethyst\Tests\Managers;

use Railken\Amethyst\Fakers\AttributableFaker;
use Railken\Amethyst\Managers\AttributableManager;
use Railken\Amethyst\Tests\BaseTest;
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
