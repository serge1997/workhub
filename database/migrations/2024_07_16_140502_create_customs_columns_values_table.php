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
        Schema::create('customs_columns_values', function (Blueprint $table) {
            $table->increments('id');
            $table->string('value')->nullable();
            $table->integer('custom_column_id')->unsigned()->nullable();
            $table->integer('task_id')->unsigned();
            $table->foreign('custom_column_id')->references('id')
                ->on('custom_columns')->onDelete('cascade');
            $table->foreign('task_id')->references('id')
                ->on('tasks')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customs_columns_values');
    }
};
