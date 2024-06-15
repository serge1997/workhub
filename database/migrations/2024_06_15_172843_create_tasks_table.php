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
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 180);
            $table->string('desctiption', 255)->nullable();
            $table->datetime('execution_delay');
            $table->integer('user_id')->unsigned();
            $table->integer('manager_id')->unsigned();
            $table->datetime('deleted_at')->nullable();
            $table->string('deleted_reason')->nullable();
            $table->enum('priority', ['ALT', 'MED', 'BAX']);
            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');
            $table->foreign('manager_id')->references('id')
                ->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
