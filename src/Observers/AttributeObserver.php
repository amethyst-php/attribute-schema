<?php

namespace Amethyst\Observers;

use Amethyst\Models\Attribute;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Arr;

class AttributeObserver
{
    /**
     * Handle the Attribute "created" event.
     *
     * @param \Amethyst\Models\Attribute $attribute
     */
    public function created(Attribute $attribute)
    {
        $this->updated($attribute, false);
    }

    /**
     * Handle the Attribute "updated" event.
     *
     * @param \Amethyst\Models\Attribute $attribute
     * @param bool $onChange
     */
    public function updated(Attribute $attribute, bool $onChange = true)
    {
        $data = app('amethyst')->findDataByName($attribute->model);


        Schema::table(Arr::get($data, 'table'), function (Blueprint $table) use ($attribute, $onChange) {

            if ($onChange) {
                $oldName = $attribute->getOriginal()['name'];

                if ($attribute->name !== $oldName) {
                    $table->renameColumn($oldName, $attribute->name);
                }
            }
        });
        
        Schema::table(Arr::get($data, 'table'), function (Blueprint $table) use ($attribute, $onChange) {

            $method = $this->getMethod($attribute);

            $column = $table->$method($attribute->name);

            if (!$attribute->required) {
                $column->nullable();
            }

            if ($onChange) {
                $column->change();
            }
        });

        $this->reload($attribute);
    }

    /**
     * Handle the Attribute "deleted" event.
     *
     * @param \Amethyst\Models\Attribute $attribute
     */
    public function deleted(Attribute $attribute)
    {
        $data = app('amethyst')->findDataByName($attribute->model);

        Schema::table(Arr::get($data, 'table'), function (Blueprint $table) use ($attribute) {

            $column = $table->dropColumn($attribute->name);
        });

        $this->reload($attribute);
    }

    /**
     * @param Attribute $attribute
     *
     * @return string
     */
    public function getMethod(Attribute $attribute): string
    {
        return $attribute->schema;
    }

    public function reload(Attribute $attribute)
    {
        $data = app('amethyst')->findDataByName($attribute->model);

        Arr::get($data, 'model')::$internalInitialization = null;

        event(new \Railken\EloquentMapper\Events\EloquentMapUpdate($attribute->model));
    }
}
