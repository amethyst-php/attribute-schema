<?php

namespace Amethyst\Observers;

use Amethyst\Models\Attribute;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Railken\Lem\Attributes\BelongsToAttribute;

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
     * @param bool                       $onChange
     */
    public function updated(Attribute $attribute, bool $onChange = true)
    {
        $data = app('amethyst')->findDataByName($attribute->model);

        Schema::table($data->newEntity()->getTable(), function (Blueprint $table) use ($attribute, $onChange) {
            if ($onChange) {
                $oldName = $attribute->getOriginal()['name'];

                if ($attribute->name !== $oldName) {
                    $table->renameColumn($oldName, $attribute->name);
                }
            }
        });

        Schema::table($data->newEntity()->getTable(), function (Blueprint $table) use ($attribute, $onChange) {
            $method = $this->getMethod($attribute);

            $column = $table->$method($attribute->name);

            if (is_subclass_of($attribute->schema, BelongsToAttribute::class)) {
                $column->unsigned();
            }

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

        Schema::table($data->newEntity()->getTable(), function (Blueprint $table) use ($attribute) {
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
        $class = config('amethyst.attribute.schema.'.$attribute->schema);

        return $class::make($attribute->name)->getSchema();
    }

    public function reload(Attribute $attribute)
    {
        $data = app('amethyst')->findDataByName($attribute->model);

        $model = $data->newEntity();

        $model::$internalInitialization = null;

        app('amethyst.attributable')->reload();

        event(new \Railken\EloquentMapper\Events\EloquentMapUpdate($attribute->model));
    }
}
