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
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('solution_id')->after('observation');
            $table->unsignedBigInteger('manufacturer_id')->after('solution_id');
            $table->unsignedBigInteger('supplier_id')->after('manufacturer_id');

            $table->foreign('solution_id')->references('id')->on('solutions')->onDelete('cascade'); // Ensure 'solutions' is correct
            $table->foreign('manufacturer_id')->references('id')->on('manufacturers')->onDelete('cascade'); // Fixed typo here
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade'); // Ensure 'suppliers' is correct
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop foreign key constraints first
            $table->dropForeign(['solution_id']);
            $table->dropForeign(['manufacturer_id']);
            $table->dropForeign(['supplier_id']);

            // Now drop the columns
            $table->dropColumn(['solution_id', 'manufacturer_id', 'supplier_id']);
        });
    }
};
