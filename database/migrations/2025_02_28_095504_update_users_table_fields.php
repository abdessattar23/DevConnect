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
        Schema::table('users', function (Blueprint $table) {
            // Check if name column exists and rename it to fullname if it does
            if (Schema::hasColumn('users', 'name') && !Schema::hasColumn('users', 'fullname')) {
                $table->renameColumn('name', 'fullname');
            }
            
            // Add additional profile fields if they don't already exist
            if (!Schema::hasColumn('users', 'bio')) {
                $table->text('bio')->nullable();
            }
            
            if (!Schema::hasColumn('users', 'profile_picture')) {
                $table->string('profile_picture')->nullable();
            }
            
            if (!Schema::hasColumn('users', 'cover_picture')) {
                $table->string('cover_picture')->nullable();
            }
            
            if (!Schema::hasColumn('users', 'website')) {
                $table->string('website')->nullable();
            }
            
            if (!Schema::hasColumn('users', 'github_url')) {
                $table->string('github_url')->nullable();
            }
            
            if (!Schema::hasColumn('users', 'linkedin_url')) {
                $table->string('linkedin_url')->nullable();
            }
            
            if (!Schema::hasColumn('users', 'language')) {
                $table->string('language')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Only attempt to revert changes that might have been made
            if (Schema::hasColumn('users', 'fullname') && !Schema::hasColumn('users', 'name')) {
                $table->renameColumn('fullname', 'name');
            }
            
            // Remove columns if they exist
            $columnsToRemove = [
                'bio', 'profile_picture', 'cover_picture', 'website', 
                'github_url', 'linkedin_url', 'language'
            ];
            
            foreach ($columnsToRemove as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
