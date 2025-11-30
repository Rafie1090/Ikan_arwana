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
        Schema::create('jadwal_pakans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kolam_id')->constrained()->onDelete('cascade'); // Kolam ID
            $table->string('waktu');
            $table->string('sesi');
            $table->string('jumlah');
            $table->string('jenis_pakan');
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_pakans');
    }
};
