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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description');
            $table->string('github_url');
            $table->string('demo_url')->nullable();
            $table->string('status')->default('pending');
            $table->integer('votes_count')->default(0);
            $table->decimal('average_rating', 3, 2)->default(0);
            $table->text('rejection_reason')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
