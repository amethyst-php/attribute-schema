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
     * Handle the AttributeSchema "saving" event.
     *
     * @param \Amethyst\Models\AttributeSchema $attributeSchema
     */
    public function saving(AttributeSchema $attributeSchema)
    {
        $attributeSchema->getResolver()->saving();
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

        if ($attributeSchema->schema === 'BelongsTo' || $attributeSchema->schema === 'MorphTo') {
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
        $attributeSchema->getResolver()->deleting();

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
     * Sync with Relation schema for attributes BelongsTo and MorphTo.
     *
     * @param \Amethyst\Models\AttributeSchema $attributeSchema
     */
    public function syncRelationSchema(AttributeSchema $attributeSchema)
    {
        $newOptions = (object) Yaml::parse($attributeSchema->options);
        $originalOptions = (object) Yaml::parse(
            $attributeSchema->getOriginal()['options']
            ?? Yaml::dump(['relationName' => $newOptions->relationName])
        );

        $newRelationName = $newOptions->relationName;
        $oldRelationName = $originalOptions->relationName;

        $this->renameRelationSchemaIfRequired(
            $attributeSchema,
            $originalOptions->relationName,
            $newOptions->relationName
        );

        $this->changePayloadSchemaIfRequired(
            $attributeSchema,
            $newOptions->relationName,
            $originalOptions,
            $newOptions
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

    public function changePayloadSchemaIfRequired(AttributeSchema $attributeSchema, $relationName, $oldPayload, $newPayload)
    {
        if ($oldPayload === $newPayload) {
            return;
        }

        $relation = app('amethyst')->get('relation-schema')->getRepository()->findOneBy([
            'data' => $attributeSchema->model,
            'name' => $relationName,
        ]);

        if ($relation) {
            $relation->payload = $this->convertAttributeOptionsToRelationPayload($attributeSchema, $newPayload);
            $relation->save();
        } else {
            app('amethyst')->get('relation-schema')->createOrFail([
                'data'    => $attributeSchema->model,
                'name'    => $relationName,
                'type'    => $attributeSchema->schema,
                'payload' => $this->convertAttributeOptionsToRelationPayload($attributeSchema, $newPayload),
            ]);
        }
    }

    public function convertAttributeOptionsToRelationPayload(AttributeSchema $attributeSchema, $payload)
    {
        $obj = [];

        if ($attributeSchema->schema === 'BelongsTo') {
            if (!empty($payload->relationData)) {
                $obj['target'] = $payload->relationData;
            }
        }

        if (!empty($payload->relationKey)) {
            $obj['foreignKey'] = $payload->relationKey;
        }

        if (!empty($payload->ownerKey)) {
            $obj['ownerKey'] = $payload->ownerKey;
        }

        return Yaml::dump($obj);
    }
}
