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
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['sprint_id']);
            $table->dropForeign(['manager_id']);
        });
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->nullable()->change();
            $table->unsignedInteger('sprint_id')->nullable()->change();
            $table->unsignedInteger('manager_id')->nullable()->change();

            $table->enum('priority', ['ALT', 'MED', 'BAX'])->nullable()->change();
            $table->string('execution_delay')->nullable()->change();
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');

            $table->foreign('sprint_id')->references('id')
                ->on('sprints')->onDelete('cascade');
            $table->foreign('manager_id')->references('id')
                ->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
