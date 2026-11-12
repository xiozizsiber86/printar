<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('merchant_documents', function (Blueprint $table) {
            $table->id();

            $table->foreignId('merchant_id')
                  ->constrained('merchant_profiles')
                  ->cascadeOnDelete();

            $table->string('document_type', 100);
            $table->string('file_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('merchant_documents');
    }
};
