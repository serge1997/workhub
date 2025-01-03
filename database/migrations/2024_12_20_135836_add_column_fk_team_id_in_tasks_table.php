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
            if(!Schema::hasColumn('tasks', 'team_id')){
                $table->integer('team_id')->unsigned()->nullable()->after('user_id');
                $table->foreign('team_id')->references('id')
                    ->on('teams_spaces')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            if(Schema::hasColumn('tasks', 'team_id')){
                $table->dropForeign(['team_id']);
                $table->dropColumn('team_id');
            }
        });
    }
};
