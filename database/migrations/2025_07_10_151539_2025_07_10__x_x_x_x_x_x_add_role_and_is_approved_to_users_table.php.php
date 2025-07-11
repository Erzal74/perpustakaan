<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add role column if not exists
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('user')->after('email');
            }

            // Handle status column conversion only if is_approved exists
            if (Schema::hasColumn('users', 'is_approved')) {
                // Check if status column doesn't exist before adding
                if (!Schema::hasColumn('users', 'status')) {
                    $table->string('status')->default('pending')->after('is_approved');
                }
                
                // PostgreSQL-compatible data conversion
                if (config('database.default') === 'pgsql') {
                    DB::statement("UPDATE users SET status = CASE 
                        WHEN is_approved = true THEN 'approved' 
                        ELSE 'pending' 
                        END");
                } else {
                    // For MySQL/SQLite
                    DB::statement("UPDATE users SET status = CASE 
                        WHEN is_approved = 1 THEN 'approved' 
                        ELSE 'pending' 
                        END");
                }
                
                // Remove old column
                $table->dropColumn('is_approved');
            } elseif (!Schema::hasColumn('users', 'status')) {
                // Only add status if neither is_approved nor status exists
                $table->string('status')->default('pending')->after('role');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'status') && !Schema::hasColumn('users', 'is_approved')) {
                // Add is_approved column back
                $table->boolean('is_approved')->default(false)->after('status');
                
                // PostgreSQL-compatible data conversion
                if (config('database.default') === 'pgsql') {
                    DB::statement("UPDATE users SET is_approved = (status = 'approved')");
                } else {
                    // For MySQL/SQLite
                    DB::statement("UPDATE users SET is_approved = CASE 
                        WHEN status = 'approved' THEN 1 
                        ELSE 0 
                        END");
                }
                
                // Remove status column
                $table->dropColumn('status');
            }
            
            // Optional: Remove role column if needed
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};