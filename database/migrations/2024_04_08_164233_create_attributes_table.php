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
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();

            $table->string('column_code', 150)->nullable()->index();
            $table->string('name', 200)->nullable();
            $table->integer('index')->nullable()->default(1);
            $table->string('model_lookup')->nullable()->index();
            $table->boolean('is_required')->nullable()->default(0);
            $table->boolean('is_unique')->nullable()->default(0);
            $table->string('model')->nullable()->index();
            $table->boolean('active')->nullable()->default(ModelStatusEnum::ACTIVE->value);
            $table->foreignId('attribute_type_id')->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attributes');
    }
};
