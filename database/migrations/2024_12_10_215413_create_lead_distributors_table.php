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
        Schema::create('lead_distributors', function (Blueprint $table) {
            $table->id();

            $table->string('full_name')->nullable();
            $table->string('dni_or_ruc')->nullable();
            $table->string('phone_1')->nullable();
            $table->string('phone_2')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('code_ubigeo', 6)->index();

            $table->boolean('has_store')->default(false);
            $table->boolean('sells_gas_cylinders')->default(false);
            $table->string('brands_sold')->nullable();
            $table->string('selling_time')->nullable();
            $table->integer('monthly_sales')->nullable();
            $table->boolean('accepts_data_policy')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_distributors');
    }
};
