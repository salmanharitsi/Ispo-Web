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
        Schema::create('ahp_prinsips', function (Blueprint $table) {
            $table->id();
            
            // P1 row
            $table->decimal('p1_p1', 10, 4)->nullable();
            $table->decimal('p1_p2', 10, 4)->nullable();
            $table->decimal('p1_p3', 10, 4)->nullable();
            $table->decimal('p1_p4', 10, 4)->nullable();
            $table->decimal('p1_p5', 10, 4)->nullable();

            // P2 row
            $table->decimal('p2_p1', 10, 4)->nullable();
            $table->decimal('p2_p2', 10, 4)->nullable();
            $table->decimal('p2_p3', 10, 4)->nullable();
            $table->decimal('p2_p4', 10, 4)->nullable();
            $table->decimal('p2_p5', 10, 4)->nullable();

            // P3 row
            $table->decimal('p3_p1', 10, 4)->nullable();
            $table->decimal('p3_p2', 10, 4)->nullable();
            $table->decimal('p3_p3', 10, 4)->nullable();
            $table->decimal('p3_p4', 10, 4)->nullable();
            $table->decimal('p3_p5', 10, 4)->nullable();

            // P4 row
            $table->decimal('p4_p1', 10, 4)->nullable();
            $table->decimal('p4_p2', 10, 4)->nullable();
            $table->decimal('p4_p3', 10, 4)->nullable();
            $table->decimal('p4_p4', 10, 4)->nullable();
            $table->decimal('p4_p5', 10, 4)->nullable();

            // P5 row
            $table->decimal('p5_p1', 10, 4)->nullable();
            $table->decimal('p5_p2', 10, 4)->nullable();
            $table->decimal('p5_p3', 10, 4)->nullable();
            $table->decimal('p5_p4', 10, 4)->nullable();
            $table->decimal('p5_p5', 10, 4)->nullable();

            // Jumlah Kolom
            $table->decimal('jumlah_p1', 10, 4)->nullable();
            $table->decimal('jumlah_p2', 10, 4)->nullable();
            $table->decimal('jumlah_p3', 10, 4)->nullable();
            $table->decimal('jumlah_p4', 10, 4)->nullable();
            $table->decimal('jumlah_p5', 10, 4)->nullable();

            $cols = ['p1', 'p2', 'p3', 'p4', 'p5'];
            // Tabel 4.2 Normalisasi
            foreach ($cols as $row) {
                foreach ($cols as $col) {
                    $table->decimal("norm_{$row}_{$col}", 10, 4)->nullable();
                }
            }
            // Tabel 4.3 Bobot Prioritas
            foreach ($cols as $row) {
                $table->decimal("bobot_{$row}", 10, 4)->nullable();
            }
            // Tabel 4.4 Matriks Penjumlahan
            foreach ($cols as $row) {
                foreach ($cols as $col) {
                    $table->decimal("matriks_penjumlahan_{$row}_{$col}", 10, 4)->nullable();
                }
            }
            // Tabel 4.4 Jumlah Baris
            foreach ($cols as $row) {
                $table->decimal("jumlah_baris_{$row}", 10, 4)->nullable();
            }
            // Tabel 4.5 Consistency Vector
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
        Schema::dropIfExists('ahp_prinsips');
    }
};
