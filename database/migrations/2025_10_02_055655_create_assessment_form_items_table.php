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
        Schema::create('assessment_form_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('form_id')->unsigned();
            $table->string('label', 200);
            $table->enum('type', ['numeric', 'scale_letter', 'boolean', 'text']);
            $table->decimal('weight', 6, 2)->default(0.00);
            $table->boolean('required')->default(true);
            $table->integer('sort_order')->default(0);

            $table->foreign('form_id')->references('id')->on('assessment_forms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_form_items');
    }
};
