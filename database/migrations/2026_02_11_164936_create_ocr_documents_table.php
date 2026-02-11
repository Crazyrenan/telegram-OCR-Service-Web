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
        // PENTING: Menggunakan connection('mysql_ocr') agar masuk ke database ocr_rnd
        Schema::connection('mysql_ocr')->create('ocr_documents', function (Blueprint $table) {
            $table->id();
            $table->string('original_filename');
            $table->string('stored_path');
            $table->longText('extracted_text');
            $table->json('word_data')->nullable();
            $table->string('thumbnail_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql_ocr')->dropIfExists('ocr_documents');
    }
};