<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $models = config('promocodes.models');

        Schema::create($models['promocode_usage_table']['table_name'], function (Blueprint $table) use ($models) {
            $table->id();
            $table->foreignId($models['promocode_usage_table']['promocode_foreign_id'])->constrained($models['promocodes']['table_name'], $models['promocodes']['id'])->cascadeOnDelete();
            $table->foreignId($models['promocode_usage_table']['user_id_foreign_id'])->constrained($models['users']['table_name'], $models['users']['id'])->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $models = config('promocodes.models');

        Schema::drop($models['promocode_usage_table']['table_name']);
    }
};
