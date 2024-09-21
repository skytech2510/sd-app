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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('spouse');
            $table->integer('person_type');
            $table->string('document');
            $table->string('extra_document');
            $table->string('birth_date')->nullable();
            $table->string('gender')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('zip_code');
            $table->string('address');
            $table->string('number_address');
            $table->string('complement_address')->nullable();
            $table->string('extra_address')->nullable();
            $table->string('region');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('state_id');
            $table->string('accountable_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('cellphone');
            $table->string('email');
            $table->string('site')->nullable();
            $table->string('social_network')->nullable();
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
        Schema::dropIfExists('clients');
    }
};
