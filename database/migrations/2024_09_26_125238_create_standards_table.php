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
        Schema::create('standards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('solution_id');
            $table->unsignedBigInteger('manufacturer_id');
            $table->json('collection_ids');
            $table->json('colors')->nullable();
            $table->double('min_width', 5, 2)->nullable()->default(0);
            $table->double('max_width', 5, 2)->nullable()->default(0);
            $table->double('min_height', 5, 2)->nullable()->default(0);
            $table->double('max_height', 5, 2)->nullable()->default(0);
            $table->double('max_area', 5, 2)->nullable()->default(0);
            $table->string('product_feature')->nullable()->default(null);
            $table->string('NCM');
            $table->string('CFOP');
            $table->json('drives')->nullable();
            $table->json('optionals')->nullable();
            $table->json('supplies')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('standards');
    }
};
