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
        Schema::create('page_multiple_contents', function (Blueprint $table) {
            $table->id();
            $table->json('json_value')->nullable();
            $table->integer('index')->default(0);
            $table->foreignId('page_multiple_field_id')->constrained('page_multiple_fields')->onDelete('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('page_multiple_contents');
    }
};
