<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            Schema::table('articles', function (Blueprint $table) {
                $table->foreignId('user_id')->default(1)->after('id')->constrained()->cascadeOnDelete();
                $table->string('cover')->nullable()->after('content');
            });
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
