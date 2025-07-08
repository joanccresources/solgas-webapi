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
        Schema::create('page_multiple_fields', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('page_multiple_fields');
    }
};
