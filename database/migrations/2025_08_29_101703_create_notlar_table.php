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
        Schema::create('notlar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ogrenci_id')->constrained('ogrenciler')->onDelete('cascade');
            $table->foreignId('ders_id')->constrained('dersler')->onDelete('cascade');
            $table->integer('not');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notlar');
    }
};
