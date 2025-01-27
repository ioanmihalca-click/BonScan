<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('situatii_centralizatoare', function (Blueprint $table) {
            $table->id();
            $table->string('perioada'); // ex: '2024-Q1' sau '2024-01'
            $table->string('status')->default('draft'); // draft, finalized
            $table->json('metadata')->nullable(); // Pentru informații adiționale (ex: user, departament)
            $table->timestamp('generated_at')->nullable();
            $table->timestamp('finalized_at')->nullable();
            $table->timestamps();
        });

        // Tabel pivot pentru relația multe-la-multe între situații și bonuri
        Schema::create('situatie_bon', function (Blueprint $table) {
            $table->id();
            $table->foreignId('situatie_id')->constrained('situatii_centralizatoare')->onDelete('cascade');
            $table->foreignId('bon_id')->constrained('bonuri')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('situatie_bon');
        Schema::dropIfExists('situatii_centralizatoare');
    }
};