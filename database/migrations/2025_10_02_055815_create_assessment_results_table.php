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
        Schema::create('assessment_results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('form_id')->unsigned();
            $table->integer('mahasiswa_user_id')->unsigned();
            $table->decimal('total_percent', 7, 2);
            $table->string('letter_grade', 5)->nullable();
            $table->decimal('gpa_point', 4, 2)->nullable();
            $table->datetime('decided_at')->useCurrent();
            $table->integer('decided_by')->unsigned();

            $table->foreign('form_id')->references('id')->on('assessment_forms')->onDelete('cascade');
            $table->foreign('mahasiswa_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('decided_by')->references('id')->on('users')->onDelete('cascade');

            $table->unique(['form_id', 'mahasiswa_user_id'], 'uq_result');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_results');
    }
};
