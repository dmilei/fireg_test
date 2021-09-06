<?php

use App\Http\Controllers\FireExtinguishersController;
use App\Http\Controllers\OptionsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::name('api.')
    ->group(function () {
        Route::get('options', [OptionsController::class, 'index'])->name('options.index');

        Route::get('extinguishers', [FireExtinguishersController::class, 'index'])->name('extinguishers.index');
        Route::post('extinguishers', [FireExtinguishersController::class, 'store'])->name('extinguishers.store');
        Route::put('extinguishers/{fireExtinguisher}', [FireExtinguishersController::class, 'update'])
            ->name('extinguishers.update');
        Route::delete('extinguishers/{fireExtinguisher}', [FireExtinguishersController::class, 'destroy'])
            ->name('extinguishers.destroy');
    });
