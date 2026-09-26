<?php

declare(strict_types=1);

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
        Schema::table('users', function (Blueprint $table): void {
            $table->timestamp('suspended_at')->nullable()->index()->after('settings');
            // A null suspended_until on a suspended account means the
            // suspension is permanent until a moderator lifts it.
            $table->timestamp('suspended_until')->nullable()->after('suspended_at');
            $table->string('suspension_reason')->nullable()->after('suspended_until');
            $table->foreignId('suspended_by_id')->nullable()->after('suspension_reason')
                ->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('suspended_by_id');
            $table->dropColumn(['suspended_at', 'suspended_until', 'suspension_reason']);
        });
    }
};
