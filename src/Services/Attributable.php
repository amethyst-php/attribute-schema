<?php

namespace Railken\Amethyst\Services;

use Railken\Lem\Manager;
use Railken\Amethyst\Managers\AttributableManager;
use Railken\Amethyst\Models;
use Railken\Lem\Contracts\ManagerContract;
use Illuminate\Support\Facades\Config;
use Railken\Lem\Contracts\EntityContract;
use Railken\Lem\Attributes\ArrayAttribute;

class Attributable
{
	public function boot()
	{
        Manager::listen('boot', function($data) {

            $manager = $data->manager;

            $name = $manager->newEntity()->getMorphName();

            if (!app('amethyst')->validMorphRelation('attribute-value', 'attributable', $name)) {
                return;
            }

            $attributableManager = new AttributableManager();

            $attributables = $attributableManager->getRepository()->findBy(['attributable_type' => $name]);

            $attribute = AttrsAttribute::make('attrs')->setManager($manager);
            $attribute->boot();

            $manager->addAttribute($attribute);
        });
	}

	public function attachAttrsToModel($builder)
	{	
		$model = $builder->getModel();

        $name = $model->getMorphName();

        if (!app('amethyst')->validMorphRelation('attribute-value', 'attributable', $name)) {   
        	throw new \BadMethodCallException(sprintf("Method %s:%s() doesn't exist", get_class($model), 'attrs'));
        }

       	if (!$model->internalAttributes->has('attrs')) {
       		$all = $this->getSchemaAttributesByName($model->getMorphName())->mapWithKeys(function ($item) {
       			return [$item->attribute->name => null];
       		});

       		$values = $model->attributeValues()->get()->mapWithKeys(function ($item) {
	       		return [$item->attribute->name => $item->value];
	       	});

       		$model->internalAttributes->set('attrs', AttributeBag::factory(array_merge($all->toArray(), $values->toArray())));
	    }

	    return $model->internalAttributes->get('attrs', AttributeBag::factory());
	}

	public function findAttributeByName(string $name)
	{
		return Models\Attribute::where('name', $name)->first();
	}

	public function getSchemaAttributesByName($model)
	{
		return Models\Attributable::where('attributable_type', $model)->get();
	}
}