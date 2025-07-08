<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('page_fields', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('variable')->nullable();
            $table->integer('index')->default(0)->nullable();
            $table->foreignId('page_section_id')->constrained()->onDelete('cascade');
            $table->foreignId('page_field_type_id')->constrained('page_field_types')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('page_fields');
    }
};
