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

class AttributeSchemaMorphToTest extends AttributeSchemaCommonTest
{
    public function testBasicMorphTo()
    {
        $this->resetFields();
        
        $foos = $this->commonField('target_key', 'DataName', ['foo'], ['invalidName']);

        $this->commonField('target_id', 'MorphTo', [['target_key' => 'foo', 'target_id' => $foos[0]->id]], [999], Yaml::dump([
        	'relationName' => 'target',
        	'relationKey' => 'target_key'
        ]));
        
        try {
            $this->resetFields();
        } catch (\Amethyst\Exceptions\RequireDependencyException $e) {
            $this->assertEquals(1, 1);
        }

        // Target_id requires target_key, so first we need to delete target_id
        \Amethyst\Models\AttributeSchema::where('name', 'target_id')->first()->delete();

        $this->resetFields();
    }
}
