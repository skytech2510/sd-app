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
        Schema::create('fabrics', function (Blueprint $table) {
            $table->id();
            $table->string('fabric_cod');
            $table->string('name');
            $table->string('fabric_width');
            $table->string('composition');
            $table->string('colors');
            $table->unsignedBigInteger('collection_id');
            $table->decimal('cost');
            $table->decimal('discount');
            $table->decimal('ST');
            $table->decimal('IPI');
            $table->decimal('shipping');
            $table->decimal('price');
            $table->timestamps();
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('company_id');

            $table->foreign('collection_id')->references('id')->on('collections');
            $table->foreign('status_id')->references('id')->on('status');
            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fabrics');
    }
};
