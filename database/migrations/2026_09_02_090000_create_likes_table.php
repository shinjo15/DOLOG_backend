<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('likes', function (Blueprint $table): void {
            $table->uuid('account_identifier');
            $table->uuid('post_identifier');
            $table->timestamps();
            $table->unique(['account_identifier', 'post_identifier']);
            $table->foreign('post_identifier')->references('post_identifier')->on('posts')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
