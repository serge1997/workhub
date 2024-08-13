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
        Schema::table('tasks_activities', function (Blueprint $table) {
            $table->boolean('is_readed')->default(false)->after('origin_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks_activities', function (Blueprint $table) {
            $table->dropColumn('is_readed');
        });
    }
};
