<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rezultat_ocr', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bon_id')->constrained('bonuri')->onDelete('cascade');
            $table->string('furnizor');
            $table->string('numar_bon');
            $table->date('data_bon');
            $table->decimal('cantitate_facturata', 10, 2);
            $table->decimal('cantitate_utilizata', 10, 2)->nullable();
            $table->json('raw_data')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rezultat_ocr');
    }
};