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
            $table->string('product_name', 100);
            $table->enum('product_type', ['producto', 'servicio']);
            $table->decimal('product_price', 10, 2);
            $table->boolean('product_status')->default(true);
            $table->unsignedBigInteger('company_id')->nullable(); // Relación con companies
            $table->timestamps();

            // Clave foránea
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
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
