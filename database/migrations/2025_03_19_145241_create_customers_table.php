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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name', 100);
            $table->string('customer_lastname', 100);
            $table->string('customer_phone', 20);
            $table->string('customer_email', 100);
            $table->boolean('customer_status')->default(true);
            $table->unsignedBigInteger('company_id')->nullable(); // Campo para la relación
            $table->timestamps();

            // Definición de la clave foránea
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
