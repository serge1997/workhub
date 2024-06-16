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
        Schema::create('tasks_roadmap', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 160);
            $table->string('description')->nullable();
            $table->integer('task_id')->unsigned();
            $table->foreign('task_id')->references('id')
                ->on('tasks')->onDelete('cascade');
            $table->datetime('deleted_at')->nullable();
            $table->string('deleted_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks_roadmap');
    }
};
