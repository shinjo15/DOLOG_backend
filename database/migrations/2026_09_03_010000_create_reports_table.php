<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table): void {
            $table->uuid('report_identifier')->primary();
            $table->uuid('reporter_account_identifier');
            $table->uuid('target_account_identifier');
            $table->uuid('target_post_identifier')->nullable();
            $table->string('category', 30);
            $table->string('text', 500);
            $table->timestamps();

            $table->foreign('reporter_account_identifier')->references('account_identifier')->on('accounts')->cascadeOnDelete();
            $table->foreign('target_account_identifier')->references('account_identifier')->on('accounts')->cascadeOnDelete();
            $table->foreign('target_post_identifier')->references('post_identifier')->on('posts')->cascadeOnDelete();
            $table->unique(['reporter_account_identifier', 'target_account_identifier']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
