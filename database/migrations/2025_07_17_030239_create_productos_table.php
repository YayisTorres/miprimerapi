<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion');
            $table->decimal('precio', 8, 2); // Ej: 999999.99
            $table->integer('stock');
            $table->timestamps(); // created_at y updated_at
        });
    }

    public function down(): void {
        Schema::dropIfExists('productos');
    }
};
