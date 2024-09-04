<?php

use App\Http\Controllers\FnbController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PhaseController;

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('import', [AuthController::class, 'import']);
    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('me', [AuthController::class, 'me']);
        Route::post('update/{id}', [AuthController::class, 'update']);
        Route::delete('delete/{id}', [AuthController::class, 'delete']);
        Route::get('list-pengguna', [AuthController::class, 'listPengguna']);
        
        
        Route::group([
            'middleware' => 'auth:api'
        ], function () {
            // api secure
            
        });
    });
});

Route::group([
    'prefix' => 'project'
], function () {
    // Route::group([
        //     'middleware' => 'auth:api'
        // ], function () {
        Route::get('list-project', [ProjectController::class, 'listAllProject']);
        Route::get('detail-project/{id}', [ProjectController::class, 'detailProject']);
        Route::post('create-project', [ProjectController::class, 'createProject']);
        Route::post('update-project/{id}', [ProjectController::class, 'updateProject']);
        Route::post('action-project/{id}', [ProjectController::class, 'actionProject']);
        Route::delete('delete-project/{id}', [ProjectController::class, 'deleteProject']);
            
    // });
});

Route::group([
    'prefix' => 'phase'
], function () {
    // Route::group([
        //     'middleware' => 'auth:api'
        // ], function () {
        Route::post('create-phase', [PhaseController::class, 'createPhase']);
        Route::get('phase-detail/{id}', [PhaseController::class, 'phaseById']);
        Route::get('phase-project/{id}', [PhaseController::class, 'phaseByProject']);
        Route::post('update-phase/{id}', [PhaseController::class, 'updatePhase']);
        Route::delete('delete-phase/{id}', [PhaseController::class, 'deletePhase']);
    // });
});

