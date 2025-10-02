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
        Schema::create('assessment_response_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('response_id')->unsigned();
            $table->integer('item_id')->unsigned();
            $table->decimal('value_numeric', 7, 2)->nullable();
            $table->string('value_letter', 5)->nullable();
            $table->boolean('value_bool')->nullable();
            $table->string('value_text', 500)->nullable();

            $table->foreign('response_id')->references('id')->on('assessment_responses')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('assessment_form_items')->onDelete('cascade');

            $table->unique(['response_id', 'item_id'], 'uq_ri');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_response_items');
    }
};
