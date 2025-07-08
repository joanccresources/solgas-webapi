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
        Schema::create('employments', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->longText('description')->nullable();
            $table->string('address')->nullable();
            $table->string('code_ubigeo', 6)->index();
            $table->boolean('active')->nullable()->default(ModelStatusEnum::ACTIVE->value);
            $table->timestamp('posted_at')->nullable();
            $table->foreignId('employment_type_id')->constrained('employment_types');
            $table->foreignId('employment_area_id')->constrained('employment_areas');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employments');
    }
};
