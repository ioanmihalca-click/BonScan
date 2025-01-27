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
        Schema::create('rezultat_ocrs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bon_id')->constrained();
            $table->string('furnizor');
            $table->string('numar_bon');
            $table->date('data_bon');
            $table->decimal('cantitate', 10, 6);
            $table->decimal('valoare', 10, 2);
            $table->json('raw_data')->nullable(); // stocăm rezultatul brut OCR
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rezultat_ocrs');
    }
};
