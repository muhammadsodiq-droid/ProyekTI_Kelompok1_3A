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
        Schema::create('assessment_responses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('form_id')->unsigned();
            $table->integer('mahasiswa_user_id')->unsigned();
            $table->integer('dosen_user_id')->unsigned();
            $table->boolean('is_final')->default(false);
            $table->datetime('submitted_at')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('form_id')->references('id')->on('assessment_forms')->onDelete('cascade');
            $table->foreign('mahasiswa_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('dosen_user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unique(['form_id', 'mahasiswa_user_id', 'dosen_user_id'], 'uq_resp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_responses');
    }
};
