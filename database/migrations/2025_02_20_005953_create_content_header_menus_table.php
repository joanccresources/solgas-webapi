<?php

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
        Schema::create('content_header_menus', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('content')->nullable();
            $table->integer('index')->default(0)->nullable();
            $table->boolean('active')->default(true)->nullable();
            $table->foreignId('content_header_id')->constrained('content_headers')->onDelete('cascade');
            $table->foreignId('content_header_menu_id')->nullable()->constrained('content_header_menus')->onDelete('cascade');
            $table->foreignId('content_menu_type_id')->constrained('content_menu_types');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_header_menus');
    }
};
