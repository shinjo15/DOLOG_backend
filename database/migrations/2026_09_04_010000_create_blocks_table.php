<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blocks', function (Blueprint $table): void {
            $table->uuid('blocking_account_identifier');
            $table->uuid('blocked_account_identifier');
            $table->timestamps();
            $table->unique([
                'blocking_account_identifier',
                'blocked_account_identifier',
            ]);
            $table->foreign('blocking_account_identifier')
                ->references('account_identifier')
                ->on('accounts')
                ->cascadeOnDelete();
            $table->foreign('blocked_account_identifier')
                ->references('account_identifier')
                ->on('accounts')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blocks');
    }
};
