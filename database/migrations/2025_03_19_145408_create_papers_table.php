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
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('company_id'); // Nueva relación con companies

            $table->decimal('paper_total_price', 10, 2)->default(0.00);
            $table->boolean('is_draft')->default(false);
            $table->integer('paper_days');
            $table->timestamps();

            // Definir las relaciones
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');

            // Nueva relación con companies
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
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
