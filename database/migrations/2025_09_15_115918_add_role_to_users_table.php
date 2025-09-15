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
        // This will now run on your default 'telegram' database where the users table is.
        Schema::table('users', function (Blueprint $table) {
            // Add the 'role' column after the 'name' column
            $table->enum('role', ['manager', 'user'])->default('user')->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Also run the down migration on the default connection.
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};

