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
        Schema::create('topsis_rankings', function (Blueprint $table) {
            $table->id();
            $table->uuid('kebun_id')->unique();
            $table->foreign('kebun_id')->references('id')->on('kebun')->onDelete('cascade');
            $table->decimal('p1_score', 8, 4)->nullable();
            $table->decimal('p2_score', 8, 4)->nullable();
            $table->decimal('p3_score', 8, 4)->nullable();
            $table->decimal('p4_score', 8, 4)->nullable();
            $table->decimal('p5_score', 8, 4)->nullable();
            $table->decimal('d_plus', 8, 4)->nullable();
            $table->decimal('d_min', 8, 4)->nullable();
            $table->decimal('vi', 8, 4)->nullable();
            $table->decimal('skor', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topsis_rankings');
    }
};
