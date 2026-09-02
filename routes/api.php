<?php

declare(strict_types=1);

use App\Http\Actions\Routine\CreateRoutineAction;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(static function (): void {
    Route::post('/routines', CreateRoutineAction::class);
});
