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
        Schema::create('table_peminjaman', function (Blueprint $table) {
            $table->id();
            $table->string('buku');
            $table->unsignedBigInteger('user');
            $table->date('pengajuan');
            $table->date('tangal_peminjaman')->nullable();
            $table->date('tanggal_pengembalian')->nullable();
            $table->date('kembali')->nullable();
            $table->integer('denda')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();

            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_peminjaman');
    }
};
