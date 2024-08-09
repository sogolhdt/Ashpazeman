<?php

use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\CategoryController;
use App\Http\Controllers\V1\SubCategoryController;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});
Route::controller(CategoryController::class)->prefix('category')->group(function () {
    Route::post('/', 'store');
    Route::get('/', 'list');
});
Route::controller(SubCategoryController::class)->prefix('sub-category')->group(function () {
    Route::post('/', 'store');
    Route::get('/', 'list');
});
