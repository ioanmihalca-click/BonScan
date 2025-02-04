<?php
// database/migrations/[timestamp]_create_company_profiles_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('company_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nume_companie')->nullable();
            $table->string('cui_cnp')->nullable();
            $table->string('id_apia')->nullable();
            $table->string('localitate')->nullable();
            $table->string('judet')->nullable();
            $table->string('nume_prenume')->nullable();
            $table->string('functie')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('company_profiles');
    }
};