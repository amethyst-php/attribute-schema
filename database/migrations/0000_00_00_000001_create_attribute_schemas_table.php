<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class CreateAttributeSchemasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(Config::get('amethyst.attribute-schema.data.attribute-schema.table'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('model');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('schema');
            $table->boolean('required')->default(false);
            $table->string('regex')->nullable();
            $table->text('options')->nullable();
            $table->text('require')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists(Config::get('amethyst.attribute-schema.data.attribute-schema.table'));
    }
}
