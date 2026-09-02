<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table): void {
            $table->uuid('post_identifier')->primary();
            $table->uuid('routine_identifier')->index();
            $table->string('post_category', 20);
            $table->unsignedInteger('post_like_count')->default(0);
            $table->unsignedInteger('post_support_count')->default(0);
            $table->boolean('available')->default(true);
            $table->timestamps();

            $table
                ->foreign('routine_identifier')
                ->references('routine_identifier')
                ->on('routines')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
