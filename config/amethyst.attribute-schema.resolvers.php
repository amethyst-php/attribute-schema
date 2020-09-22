<?php

return [
    'Text'      => Amethyst\AttributeSchemaResolvers\TextResolver::class,
    'LongText'  => Amethyst\AttributeSchemaResolvers\LongTextResolver::class,
    'Number'    => Amethyst\AttributeSchemaResolvers\NumberResolver::class,
    'Email'     => Amethyst\AttributeSchemaResolvers\EmailResolver::class,
    'Enum'      => Amethyst\AttributeSchemaResolvers\EnumResolver::class,
    'Boolean'   => Amethyst\AttributeSchemaResolvers\BooleanResolver::class,
    'BelongsTo' => Amethyst\AttributeSchemaResolvers\BelongsToResolver::class,
    'Date'      => Amethyst\AttributeSchemaResolvers\DateResolver::class,
    'DateTime'  => Amethyst\AttributeSchemaResolvers\DateTimeResolver::class,
    'DataName'  => Amethyst\AttributeSchemaResolvers\DataNameResolver::class,
    'MorphTo'   => Amethyst\AttributeSchemaResolvers\MorphToResolver::class,
];
