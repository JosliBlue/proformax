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
        Schema::create('papers_products', function (Blueprint $table) {
            $table->id();
            // Claves foráneas
            $table->unsignedBigInteger('paper_id'); // Columna para la clave foránea
            $table->unsignedBigInteger('product_id'); // Columna para la clave foránea

            $table->bigInteger('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('subtotal', 10, 2);

            // Definir las relaciones
            $table->foreign('paper_id')->references('id')->on('papers')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('papers_products');
    }
};
