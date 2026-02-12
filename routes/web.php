<?php

use Illuminate\Support\Facades\Route;
use Ledgerly\UI\Http\Controllers\LedgerTimelineController;

Route::middleware(['web'])
    ->group(function () {
        Route::get('/ledgerly/timeline', LedgerTimelineController::class)
            ->name('ledgerly.timeline');
    });
