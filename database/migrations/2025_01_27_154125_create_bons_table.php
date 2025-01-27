<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bonuri', function (Blueprint $table) {
            $table->id();
            $table->string('imagine_path');
            $table->string('status')->default('processing');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bonuri');
    }
};