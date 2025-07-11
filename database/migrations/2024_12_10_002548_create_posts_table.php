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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug')->unique();
            $table->string('short_description')->nullable();
            $table->longText('content')->nullable();
            $table->string('image')->nullable();
            $table->string('thumbnail')->nullable();
            $table->boolean('active')->nullable()->default(ModelStatusEnum::ACTIVE->value);
            $table->integer('view')->nullable()->default(0);
            $table->integer('like')->nullable()->default(0);
            $table->integer('shared')->nullable()->default(0);
            $table->dateTime('publication_at')->nullable();
            $table->foreignId('user_id')->constrained('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
