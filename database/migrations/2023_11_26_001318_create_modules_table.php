<?php

use App\Enums\ModelStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150)->nullable();
            $table->string('singular_name', 150)->nullable();
            $table->string('assigned', 150)->nullable();
            $table->string('slug', 150)->nullable();
            $table->string('icon', 150)->nullable();
            $table->string('endpoint', 200)->nullable();
            $table->string('element', 200)->nullable();
            $table->string('additional_custom_actions', 200)->nullable();
            $table->json('path')->nullable();
            $table->json('columns')->nullable();
            $table->json('create_edit')->nullable();
            $table->integer('per_page')->nullable();
            $table->integer('page')->nullable();
            $table->integer('index')->nullable();
            $table->string('sort_by', 100)->nullable();
            $table->string('order_direction', 100)->nullable();
            $table->boolean('is_crud')->nullable()->default(1);
            $table->boolean('show_in_sidebar')->nullable()->default(1);
            $table->boolean('is_removable')->nullable()->default(0);
            $table->boolean('active')->nullable()->default(ModelStatusEnum::ACTIVE->value);

            $table->bigInteger('module_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
