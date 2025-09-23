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
        Schema::create('verification_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('document_type')->default('ID Card'); // e.g., 'Passport', 'ID Card'
            $table->string('original_filename');
            
            // Fields extracted from the OCR process
            $table->string('extracted_name')->nullable();
            $table->string('extracted_id_number')->nullable();
            
            $table->string('status')->default('pending'); // pending, verified, rejected
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verification_requests');
    }
};
