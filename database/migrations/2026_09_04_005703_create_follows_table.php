<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('follows', function (Blueprint $table): void {
            $table->uuid('following_account_identifier');
            $table->uuid('followed_account_identifier');
            $table->timestamps();
            $table->unique([
                'following_account_identifier',
                'followed_account_identifier',
            ]);
            $table->foreign('following_account_identifier')
                ->references('account_identifier')
                ->on('accounts')
                ->cascadeOnDelete();
            $table->foreign('followed_account_identifier')
                ->references('account_identifier')
                ->on('accounts')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('follows');
    }
};
