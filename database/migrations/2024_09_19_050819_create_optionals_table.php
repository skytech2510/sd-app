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
        Schema::create('optionals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('observation');
            $table->string('annotation');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('manufacturer_id');
            $table->integer('item');
            $table->float('price', 8, 2);
            $table->timestamps();

            $table->foreign('status_id')->references('id')->on('status');
            $table->foreign('manufacturer_id')->references('id')->on('manufacturers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('optionals');
    }
};
