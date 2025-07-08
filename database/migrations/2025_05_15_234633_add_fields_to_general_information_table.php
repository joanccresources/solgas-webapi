<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('general_information', function (Blueprint $table) {
            $table->string('title_cookie', 200)->nullable();
            $table->text('description_cookie', 200)->nullable();
            $table->string('more_information_cookie', 200)->nullable();
            $table->string('text_button_necessary_cookie', 200)->nullable();
            $table->string('text_button_allow_cookie', 200)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('general_information', function (Blueprint $table) {
            $table->dropColumn([
                'title_cookie',
                'description_cookie',
                'more_information_cookie',
                'text_button_necessary_cookie',
                'text_button_allow_cookie',
            ]);
        });
    }
};
