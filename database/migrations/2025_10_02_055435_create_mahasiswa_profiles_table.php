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
        Schema::create('mahasiswa_profiles', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->primary();
            $table->string('nim', 50)->nullable()->unique();
            $table->string('prodi', 100);
            $table->tinyInteger('semester')->unsigned()->default(5);
            $table->string('whatsapp', 30)->nullable();
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->decimal('ipk', 3, 2)->nullable();
            $table->boolean('cek_min_semester')->default(false);
            $table->boolean('cek_ipk_nilaisks')->default(false);
            $table->boolean('cek_valid_biodata')->default(false);
            $table->integer('dospem_id')->unsigned()->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('dospem_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa_profiles');
    }
};
