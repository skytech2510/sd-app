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
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('CPF');
            $table->string('birthday');
            $table->string('gender');
            $table->string('CEP');
            $table->string('address');
            $table->integer('number_address');
            $table->string('complement_address');
            $table->string('region');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('state_id');
            $table->string('accountable_name');
            $table->string('phone');
            $table->string('cellphone');
            $table->string('email');
            $table->string('site');
            $table->string('social_network');
            $table->string('bank');
            $table->string('agency');
            $table->string('account_number');
            $table->string('pix_key');
            $table->string('consultant');
            $table->timestamps();

            $table->foreign('city_id')->references('id')->on('cidades');
            $table->foreign('state_id')->references('id')->on('estados');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
