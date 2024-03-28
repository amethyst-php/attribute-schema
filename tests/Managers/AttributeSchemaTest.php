<?php

namespace Amethyst\Tests\Managers;

use Amethyst\Fakers\AttributeSchemaFaker;
use Amethyst\Managers\AttributeSchemaManager;
use Amethyst\Tests\BaseTestCase;
use Railken\Lem\Support\Testing\TestableBaseTrait;

class AttributeSchemaTest extends BaseTestCase
{
    use TestableBaseTrait;

    /**
     * Manager class.
     *
     * @var string
     */
    protected $manager = AttributeSchemaManager::class;

    /**
     * Faker class.
     *
     * @var string
     */
    protected $faker = AttributeSchemaFaker::class;
}
