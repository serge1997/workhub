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
        Schema::create('comments_response', function (Blueprint $table) {
            $table->increments("id");
            $table->string("response", 200);
            $table->integer("comment_id")->unsigned();
            $table->foreign("comment_id")->references("id")
                ->on("comments")->onDelete("cascade");
            $table->integer("user_id")->unsigned();
            $table->foreign("user_id")->references("id")
                ->on("users")->onDelete("cascade");
            $table->datetime("deleted_at")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments_response');
    }
};
