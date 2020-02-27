<?php

namespace Amethyst\Observers;

use Amethyst\Models\AttributeSchema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Yaml\Yaml;

class AttributeSchemaObserver
{
    /**
     * Handle the AttributeSchema "created" event.
     *
     * @param \Amethyst\Models\AttributeSchema $attributeSchema
     */
    public function creating(AttributeSchema $attributeSchema)
    {
        $this->updating($attributeSchema, false);
    }

    /**
     * Handle the AttributeSchema "updated" event.
     *
     * @param \Amethyst\Models\AttributeSchema $attributeSchema
     * @param bool                             $onChange
     */
    public function updating(AttributeSchema $attributeSchema, bool $onChange = true)
    {
        $data = app('amethyst')->findDataByName($attributeSchema->model);
        $options = (object) Yaml::parse((string) $attributeSchema->options);

        Schema::table($data->newEntity()->getTable(), function (Blueprint $table) use ($attributeSchema, $onChange) {
            if ($onChange) {
                $oldName = $attributeSchema->getOriginal()['name'];

                if ($attributeSchema->name !== $oldName) {
                    $table->renameColumn($oldName, $attributeSchema->name);
                }
            }
        });

        Schema::table($data->newEntity()->getTable(), function (Blueprint $table) use ($attributeSchema, $onChange, $options) {
            $method = $this->getMethod($attributeSchema);

            $arguments = [$attributeSchema->name];

            if ($attributeSchema->schema === 'Number') {
                if (!empty($options->precision)) {
                    $arguments[] = $options->precision;
                }

                if (!empty($options->scale)) {
                    $arguments[] = $options->scale;
                }
            }

            $column = $table->$method(...$arguments);

            if ($attributeSchema->schema === 'BelongsTo') {
                $column->unsigned();
            }

            $column->nullable();

            if ($onChange) {
                $column->change();
            }
        });
    }

    /**
     * Handle the AttributeSchema "deleted" event.
     *
     * @param \Amethyst\Models\AttributeSchema $attributeSchema
     */
    public function deleting(AttributeSchema $attributeSchema)
    {
        $data = app('amethyst')->findDataByName($attributeSchema->model);

        Schema::table($data->newEntity()->getTable(), function (Blueprint $table) use ($attributeSchema) {
            $column = $table->dropColumn($attributeSchema->name);
        });
    }

    /**
     * @param AttributeSchema $attributeSchema
     *
     * @return string
     */
    public function getMethod(AttributeSchema $attributeSchema): string
    {
        $class = config('amethyst.attribute-schema.schema.'.$attributeSchema->schema);

        return $class::make($attributeSchema->name)->getSchema();
    }

    /**
     * Handle the AttributeSchema "created" event.
     *
     * @param \Amethyst\Models\AttributeSchema $attributeSchema
     */
    public function created(AttributeSchema $attributeSchema)
    {
        $this->reload($attributeSchema);
    }

    /**
     * Handle the AttributeSchema "updated" event.
     *
     * @param \Amethyst\Models\AttributeSchema $attributeSchema
     */
    public function updated(AttributeSchema $attributeSchema)
    {
        $this->reload($attributeSchema);
    }

    public function reload(AttributeSchema $attributeSchema)
    {
        app('amethyst.attributable')->reload();

        $data = app('amethyst')->findDataByName($attributeSchema->model);

        // Reloading manager
        $data->boot();

        $model = $data->newEntity();

        // Reloading model
        $model->ini($model->__config, true);

        event(new \Railken\EloquentMapper\Events\EloquentMapUpdate($attributeSchema->model));
    }
}
