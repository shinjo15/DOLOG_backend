<?php

declare(strict_types=1);

use App\Http\Actions\Account\CreateAccountAction;
use App\Http\Actions\Like\GetMyLikesAction;
use App\Http\Actions\Routine\CreateRoutineAction;
use App\Http\Actions\Support\GetMySupportsAction;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(static function (): void {
    Route::post('/accounts', CreateAccountAction::class);
    Route::post('/routines', CreateRoutineAction::class);
    Route::get('/my/likes', GetMyLikesAction::class);
    Route::get('/my/supports', GetMySupportsAction::class);
});
