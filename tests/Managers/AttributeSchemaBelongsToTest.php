<?php

namespace Amethyst\Tests\Managers;

use Amethyst\Fakers\AttributeSchemaFaker;
use Amethyst\Fakers\FooFaker;
use Amethyst\Managers\AttributeSchemaManager;
use Amethyst\Managers\FooManager;
use Amethyst\Models\Foo;
use Amethyst\Tests\BaseTest;
use Railken\Lem\Support\Testing\TestableBaseTrait;
use Symfony\Component\Yaml\Yaml;

class AttributeSchemaBelongsToTest extends AttributeSchemaCommonTest
{
    public function testBasicBelongsTo()
    {	
    	$fooManager = new FooManager();
		$foo = $fooManager->createOrFail(FooFaker::make()->parameters())->getResource();
        
        $this->commonField('parent_id', 'BelongsTo', [$foo->id], [999], Yaml::dump([
        	'relationName' => 'parent',
        	'relationData' => 'foo'
        ]));
    }
}
