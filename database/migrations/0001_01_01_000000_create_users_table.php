<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_name', 100);
            $table->string('user_email', 100)->unique();
            $table->string('user_password');
            $table->enum('user_rol', ['gerente', 'vendedor', 'pasante'])->default('vendedor');
            $table->boolean('user_status')->default(true);
            $table->unsignedBigInteger('company_id')->nullable();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
