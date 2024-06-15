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
        Schema::create('task_annexes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('annex');
            $table->integer('task_id')->unsigned();
            $table->datetime('deleted_at')->nullable();
            $table->string('deleted_reason')->nullable();
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
        Schema::dropIfExists('task_annexes');
    }
};
