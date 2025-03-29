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
        Schema::create('papers', function (Blueprint $table) {
            $table->id();

            // Claves foráneas
            $table->unsignedBigInteger('user_id'); // Columna para la clave foránea
            $table->unsignedBigInteger('customer_id'); // Columna para la clave foránea

            $table->decimal('paper_total_price', 10, 2)->default(0.00);
            $table->string('paper_days');

            // Definir las relaciones
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');

            $table->boolean('paper_status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('papers');
    }
};
