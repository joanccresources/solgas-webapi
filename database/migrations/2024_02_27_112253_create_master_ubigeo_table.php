<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterUbigeoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_ubigeo', function (Blueprint $table) {
            $table->string('code_ubigeo', 6)->primary();
            $table->string('code_department', 2);
            $table->string('department', 50);
            $table->string('code_province', 2);
            $table->string('province', 50)->nullable();
            $table->string('code_district', 2);
            $table->string('district', 50)->nullable();
            $table->string('code_number', 2)->nullable();
            $table->string('longitude', 2)->nullable();
            $table->string('latitude', 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_ubigeo');
    }
}
