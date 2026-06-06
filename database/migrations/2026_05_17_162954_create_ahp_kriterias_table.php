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
        Schema::create('ahp_kriterias', function (Blueprint $table) {
            $table->id();
            $table->string('prinsip_code')->unique(); // p1, p2, p3, p4, p5
            
            $cols = ['k1', 'k2', 'k3', 'k4', 'k5'];

            // Tabel 4.1: Input Kriteria
            foreach ($cols as $row) {
                foreach ($cols as $col) {
                    $table->decimal("{$row}_{$col}", 10, 4)->nullable();
                }
            }

            foreach ($cols as $col) {
                $table->decimal("jumlah_{$col}", 10, 4)->nullable();
            }

            // Tabel 4.2: Normalisasi
            foreach ($cols as $row) {
                foreach ($cols as $col) {
                    $table->decimal("norm_{$row}_{$col}", 10, 4)->nullable();
                }
            }

            // Tabel 4.3: Bobot Prioritas
            foreach ($cols as $row) {
                $table->decimal("bobot_{$row}", 10, 4)->nullable();
            }

            // Tabel 4.4: Matriks Penjumlahan Tiap Baris
            foreach ($cols as $row) {
                foreach ($cols as $col) {
                    $table->decimal("matriks_penjumlahan_{$row}_{$col}", 10, 4)->nullable();
                }
                $table->decimal("jumlah_baris_{$row}", 10, 4)->nullable();
            }

            // Tabel 4.5: Consistency Vector
            foreach ($cols as $row) {
                $table->decimal("cv_{$row}", 10, 4)->nullable();
            }

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ahp_kriterias');
    }
};
