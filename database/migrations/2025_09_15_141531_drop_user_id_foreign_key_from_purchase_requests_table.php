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
        // Specify the correct database connection
        Schema::connection('mysql_application')->table('purchase_requests', function (Blueprint $table) {
            // Drop the foreign key constraint.
            // The name 'purchase_requests_user_id_foreign' is a standard Laravel convention.
            $table->dropForeign('purchase_requests_user_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql_application')->table('purchase_requests', function (Blueprint $table) {
            // To make this reversible, we would re-add the constraint.
            // Note: This will only work if the tables are in the same database.
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};