<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('travels', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_public')->default(true);
            $table->string('slug')->unique();
            $table->string('name');
            $table->text('description');
            $table->integer('number_of_days');
            $table->unsignedBigInteger('create_user_id')->nullable();
            $table->unsignedBigInteger('update_user_id')->nullable();
            $table->timestamps();

            $table
                ->foreign('create_user_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table
                ->foreign('update_user_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travels');
    }
};
