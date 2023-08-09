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

        Schema::create($models['promocodes']['table_name'], function (Blueprint $table) use ($models) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->unsignedInteger('total_usages')->nullable();
            $table->boolean('multi_use')->default(false);
            $table->foreignId($models['promocodes']['bound_to_user_id_foreign_id'])->nullable()->constrained($models['users']['table_name'], $models['users']['id'])->nullOnDelete();
            $table->json('details')->nullable();
            $table->timestamp('expired_at')->nullable();
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

        Schema::drop($models['promocodes']['table_name']);
    }
};
