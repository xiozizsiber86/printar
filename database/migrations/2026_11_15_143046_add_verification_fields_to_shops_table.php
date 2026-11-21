<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->enum('verification_status', [
                'pending',
                'approved',
                'rejected',
            ])->default('pending')->after('is_active');

            $table->text('rejection_reason')->nullable()
                ->after('verification_status');
        });

        DB::table('shops')
            ->where('is_active', true)
            ->update(['verification_status' => 'approved']);
    }

    public function down(): void
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->dropColumn([
                'verification_status',
                'rejection_reason',
            ]);
        });
    }
};
