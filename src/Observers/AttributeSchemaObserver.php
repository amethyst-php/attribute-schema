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

            $arguments = $attributeSchema->getResolver()->getDatabaseArguments();

            $column = $table->$method(...$arguments);

            $attributeSchema->getResolver()->callDatabaseOptions($column);

            $column = $column->nullable();

            if ($onChange) {
                $column->change();
            }
        });

        if ($attributeSchema->schema === 'BelongsTo') {
            $this->syncRelationSchema($attributeSchema);
        }
    }

    /**
     * Handle the AttributeSchema "deleting" event.
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
     * Handle the AttributeSchema "deleted" event.
     *
     * @param \Amethyst\Models\AttributeSchema $attributeSchema
     */
    public function deleted(AttributeSchema $attributeSchema)
    {
        $this->reload($attributeSchema);
    }

    /**
     * @param AttributeSchema $attributeSchema
     *
     * @return string
     */
    public function getMethod(AttributeSchema $attributeSchema): string
    {
        return $attributeSchema->getResolver()->getInstanceAttribute()->getSchema();
    }

    public function reload(AttributeSchema $attributeSchema)
    {
        app('amethyst.attribute-schema')->reload();

        $data = app('amethyst')->findDataByName($attributeSchema->model);

        // Reloading manager
        $data->boot();

        $model = $data->newEntity();

        // Reloading model
        $model->ini($model->__config, true);

        event(new \Railken\EloquentMapper\Events\EloquentMapUpdate($attributeSchema->model));
    }

     /**
     * Sync with Relation schema for attributes BelongsTo and MorphTo
     *
     * @param \Amethyst\Models\AttributeSchema $attributeSchema
     */
    public function syncRelationSchema(AttributeSchema $attributeSchema)
    {
        $newOptions = (object) Yaml::parse($attributeSchema->options);
        $originalOptions = (object) Yaml::parse(
            $attributeSchema->getOriginal()['options'] 
            ?? Yaml::dump([
                'relationName' => $newOptions->relationName,
                'relationData' => null // force create
        ]));

        $newRelationName = $newOptions->relationName;
        $oldRelationName = $originalOptions->relationName;

        $this->renameRelationSchemaIfRequired(
            $attributeSchema,
            $originalOptions->relationName,
            $newOptions->relationName
        );

        $this->changeTargetRelationSchemaIfRequired(
            $attributeSchema,
            $newOptions->relationName,
            $originalOptions->relationData,
            $newOptions->relationData
        );

    }

    public function renameRelationSchemaIfRequired(AttributeSchema $attributeSchema, $oldRelationName, $newRelationName)
    {
        if ($oldRelationName === $newRelationName) {
            return;
        }

        $relation = app('amethyst')->get('relation-schema')->getRepository()->findOneBy([
            'data' => $attributeSchema->model,
            'name' => $oldRelationName,
        ]);

        $relation->name = $newRelationName;
        $relation->save();
    }

    public function changeTargetRelationSchemaIfRequired(AttributeSchema $attributeSchema, $relationName, $oldRelationTarget, $newRelationTarget)
    {
        if ($oldRelationTarget === $newRelationTarget) {
            return;
        }

        $relation = app('amethyst')->get('relation-schema')->getRepository()->findOneBy([
            'data' => $attributeSchema->model,
            'name' => $relationName
        ]);

        if ($relation) {
            $relation->payload = Yaml::dump(['target' => $newRelationTarget]);
            $relation->save();
        } else {
            app('amethyst')->get('relation-schema')->createOrFail([
                'data' => $attributeSchema->model,
                'name' => $relationName,
                'type' => $attributeSchema->schema,
                'payload' => Yaml::dump(['target' => $newRelationTarget])
            ]);
        }
    }

}
