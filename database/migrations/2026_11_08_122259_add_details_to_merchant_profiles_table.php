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
        Schema::table('merchant_profiles', function (Blueprint $table) {
            $table->foreignId('user_id')
                  ->unique()
                  ->after('id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->string('phone', 20)->nullable()->after('user_id');

            $table->enum('verification_status', [
                'pending',
                'approved',
                'rejected'
            ])->default('pending')->after('phone');

            $table->foreignId('verified_by')
                  ->nullable()
                  ->after('verification_status')
                  ->constrained('users')
                  ->nullOnDelete();

            $table->timestamp('verified_at')->nullable()->after('verified_by');

            $table->text('rejection_reason')->nullable()->after('verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('merchant_profiles', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['verified_by']);

            $table->dropColumn([
                'user_id',
                'phone',
                'verification_status',
                'verified_by',
                'verified_at',
                'rejection_reason'
            ]);
        });
    }
};
