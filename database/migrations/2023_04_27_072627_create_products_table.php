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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('status_id');
            $table->string('supplier_code');
            $table->string('item');
            $table->string('color');
            $table->string('size');
            $table->string('NCM');
            $table->string('CFOP');
            $table->string('cost');
            $table->integer('discount');
            $table->integer('ST');
            $table->integer('IPI');
            $table->integer('freight');
            $table->integer('markup');
            $table->integer('price');
            $table->string('observation');
            $table->timestamps();

            $table->foreign('status_id')->references('id')->on('status')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
