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
        Schema::create('surat_balasan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mahasiswa_id')->unsigned();
            $table->integer('mitra_id')->unsigned()->nullable();
            $table->string('mitra_nama_custom', 150)->nullable();
            $table->string('file_path');
            $table->enum('status_validasi', ['menunggu', 'belum_valid', 'tervalidasi', 'revisi'])->default('menunggu');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('mahasiswa_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('mitra_id')->references('id')->on('mitra')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_balasan');
    }
};
