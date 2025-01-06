<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('model_id');
            $table->boolean('is_enabled')->default(true);

            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('admins');
            $table->foreign('type_id')->references('id')->on('agent_types');
            $table->foreign('model_id')->references('id')->on('agent_models');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
