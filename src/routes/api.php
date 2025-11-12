<?php

use Illuminate\Support\Facades\Route;
use App\Api\Http\Controllers\CompanyController;

Route::middleware('auth:sanctum')->prefix('company')->group(function () {
    Route::get('{edrpou}/versions', [CompanyController::class, 'versions']);
    Route::post('/', [CompanyController::class, 'store']);
});
