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
        Schema::create('monitoring_air', function (Blueprint $table) {
            $table->id();

            // RELASI KE KOLOM (WAJIB)
            $table->unsignedBigInteger('kolam_id');

            $table->float('suhu');
            $table->float('ph');
            $table->float('oksigen');
            $table->float('kekeruhan')->nullable();

            $table->timestamps();

            // FOREIGN KEY (opsional tapi bagus)
            $table->foreign('kolam_id')->references('id')->on('kolams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_air');
    }
};
