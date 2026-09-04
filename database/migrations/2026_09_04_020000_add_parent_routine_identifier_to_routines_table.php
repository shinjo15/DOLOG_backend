<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('routines', function (Blueprint $table): void {
            $table->uuid('parent_routine_identifier')->nullable()->index()->after('routine_identifier');
            $table
                ->foreign('parent_routine_identifier')
                ->references('routine_identifier')
                ->on('routines')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('routines', function (Blueprint $table): void {
            $table->dropForeign(['parent_routine_identifier']);
            $table->dropColumn('parent_routine_identifier');
        });
    }
};
