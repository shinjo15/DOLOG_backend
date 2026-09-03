<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table): void {
            $table->uuid('account_identifier')->primary();
            $table->string('account_name', 50);
            $table->string('account_bio', 300)->nullable();
            $table->string('email_address')->unique();
            $table->boolean('available')->default(true);
            $table->timestamps();
        });

        Schema::create('favorite_tags', function (Blueprint $table): void {
            $table->uuid('account_identifier');
            $table->uuid('tag_identifier');
            $table->timestamps();
            $table->foreign('account_identifier')->references('account_identifier')->on('accounts')->cascadeOnDelete();
            $table->foreign('tag_identifier')->references('tag_identifier')->on('tags')->cascadeOnDelete();
            $table->unique(['account_identifier', 'tag_identifier']);
        });

        Schema::create('account_social_links', function (Blueprint $table): void {
            $table->uuid('account_identifier');
            $table->string('type');
            $table->string('url');
            $table->unsignedInteger('position');
            $table->timestamps();
            $table->foreign('account_identifier')->references('account_identifier')->on('accounts')->cascadeOnDelete();
            $table->unique(['account_identifier', 'position']);
        });

        Schema::create('account_credentials', function (Blueprint $table): void {
            $table->uuid('account_identifier')->primary();
            $table->string('passcode_hash');
            $table->timestamps();
            $table->foreign('account_identifier')->references('account_identifier')->on('accounts')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('account_credentials');
        Schema::dropIfExists('account_social_links');
        Schema::dropIfExists('favorite_tags');
        Schema::dropIfExists('accounts');
    }
};
