<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ItemController;


Route::get('/health', function () {
    try {
        DB::connection()->getPdo();
        return response()->json([
            'status' => 'ok',
            'database' => 'connected'
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'database' => 'disconnected'
        ], 503);
    }
});

Route::get('/items', [ItemController::class, 'index']);
Route::post('/items', [ItemController::class, 'store']);