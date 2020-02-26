<?php

namespace Amethyst\Observers;

use Amethyst\Models\Attribute;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Yaml\Yaml;

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
        $options = (object) Yaml::parse((string) $attribute->options);

        Schema::table($data->newEntity()->getTable(), function (Blueprint $table) use ($attribute, $onChange) {
            if ($onChange) {
                $oldName = $attribute->getOriginal()['name'];

                if ($attribute->name !== $oldName) {
                    $table->renameColumn($oldName, $attribute->name);
                }
            }
        });

        Schema::table($data->newEntity()->getTable(), function (Blueprint $table) use ($attribute, $onChange, $options) {
            $method = $this->getMethod($attribute);

            $arguments = [$attribute->name];

            if ($attribute->schema === 'Number') {
                if (!empty($options->precision)) {
                    $arguments[] = $options->precision;
                }

                if (!empty($options->scale)) {
                    $arguments[] = $options->scale;
                }
            }

            $column = $table->$method(...$arguments);

            if ($attribute->schema === 'BelongsTo') {
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
        app('amethyst.attributable')->reload();

        $data = app('amethyst')->findDataByName($attribute->model);

        // Reloading manager
        $data->boot();

        $model = $data->newEntity();

        // Reloading model
        $model->ini($model->__config, true);

        event(new \Railken\EloquentMapper\Events\EloquentMapUpdate($attribute->model));
    }
}
