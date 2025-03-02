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
        Schema::table('likes', function (Blueprint $table) {
            $table->foreignId('comment_id')->nullable()->after('post_id')->constrained()->onDelete('cascade');
            
            // Update unique constraint to include comment_id
            // First, we need to drop the existing constraint
            $table->dropUnique(['user_id', 'post_id']);
            
            // Add new constraint that ensures a user can only like a post or comment once
            // The post_id can be null if like is for a comment
            // The comment_id can be null if like is for a post
            $table->unique(['user_id', 'post_id', 'comment_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('likes', function (Blueprint $table) {
            // First drop the new unique constraint
            $table->dropUnique(['user_id', 'post_id', 'comment_id']);
            
            // Restore the original constraint
            $table->unique(['user_id', 'post_id']);
            
            // Remove the comment_id column
            $table->dropForeign(['comment_id']);
            $table->dropColumn('comment_id');
        });
    }
};
