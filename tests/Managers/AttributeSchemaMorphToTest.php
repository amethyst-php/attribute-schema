<?php

namespace Amethyst\Tests\Managers;

use Symfony\Component\Yaml\Yaml;
use Amethyst\Managers\FooManager;
use Amethyst\Fakers\FooFaker;

class AttributeSchemaMorphToTest extends AttributeSchemaCommonTestCase
{
    public function testBasicMorphTo()
    {
        $this->resetFields();

        $foos = $this->commonField('target_key', 'DataName', ['foo'], ['invalidName']);

        $fooManager = new FooManager();
        $foo = $fooManager->createOrFail(FooFaker::make()->parameters())->getResource();

        $this->commonField('target_id', 'MorphTo', [['target_key' => 'foo', 'target_id' => $foo->id]], [999], Yaml::dump([
            'relationName' => 'target',
            'relationKey'  => 'target_key',
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
