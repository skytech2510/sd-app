<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('fantasy_name');
            $table->string('document');
            $table->string('ie');
            $table->string('zip_code');
            $table->string('address');
            $table->string('number_address');
            $table->string('complement_address');
            $table->string('region');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('state_id');
            $table->string('accountable_name');
            $table->string('phone');
            $table->string('cellphone');
            $table->string('email');
            $table->string('site');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('company_id');
            $table->timestamps();

            $table->foreign('city_id')->references('id')->on('cidades');
            $table->foreign('state_id')->references('id')->on('estados');
            $table->foreign('status_id')->references('id')->on('status');
            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
