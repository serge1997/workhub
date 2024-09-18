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

        if (Schema::hasTable('tasks')){
            Schema::table('tasks', function (Blueprint $table) {
                $table->integer('sprint_id')->unsigned()->nullable();
                $table->foreign('sprint_id')->references('id')
                    ->on('sprints')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('sprint_id');
        });
    }
};
