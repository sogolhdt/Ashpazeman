<?php

use App\Http\Controllers\V1\AuthController;
use Illuminate\Support\Facades\Route;


// apis for main site
Route::prefix('v1')->group(base_path('routes/site/api_v1.php'));
// Route::prefix('v2')->group(base_path('routes/site/api_v2.php'));