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
        Schema::table('general_information', function (Blueprint $table) {
            $table->string('token_map')->nullable()->after('google_tag_manager_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('general_information', function (Blueprint $table) {
            $table->dropColumn('token_map');
        });
    }
};
