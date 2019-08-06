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
        $data = app('amethyst')->findDataByName($attribute->model);

        Schema::table(Arr::get($data, 'table'), function (Blueprint $table) use ($attribute) {

            $method = $this->getMethod($attribute);

            $column = $table->$method($attribute->name);

            if ($attribute->nullable) {
                $column->nullable();
            }
        });

        $this->reload($attribute);
    }

    /**
     * Handle the Attribute "updated" event.
     *
     * @param \Amethyst\Models\Attribute $attribute
     */
    public function updated(Attribute $attribute)
    {
        $data = app('amethyst')->findDataByName($attribute->model);

        Schema::table(Arr::get($data, 'table'), function (Blueprint $table) use ($attribute) {

            $method = $this->getMethod($attribute);

            $column = $table->$method($attribute->name);

            if ($attribute->nullable) {
                $column->nullable();
            }

            $column->change();
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
        if ($attribute->schema === 'Text' || $attribute->schema === 'Email') {
            return 'string';
        }

        if ($attribute->schema === 'Number') {
            return 'float';
        }

        if ($attribute->schema === 'LongText') {
            return 'text';
        }

        throw new \Exception(sprintf("Cannot find anything for %s", $attribute->schema));
    }

    public function reload(Attribute $attribute)
    {
        $data = app('amethyst')->findDataByName($attribute->model);

        Arr::get($data, 'model')::$internalInitialization = null;
        event(new \Railken\EloquentMapper\Events\EloquentMapUpdate);
    }
}
