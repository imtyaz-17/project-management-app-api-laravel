<?php

use App\Http\Controllers\Api\BoardController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get("/me", fn(Request $request) => $request->user());
    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware(['throttle:6,1'])
        ->name('verification.send');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');


    Route::get('/projects', [ProjectController::class, 'index']);
    Route::post('/project', [ProjectController::class, 'store']);
    Route::get('/project/{project}', [ProjectController::class, 'show']);
    Route::put('/project/{project}', [ProjectController::class, 'update']);
    Route::put('/project/{project}', [ProjectController::class, 'update']);
    Route::delete('/project/{project}', [ProjectController::class, 'destroy']);

//    Route::get('/project/{project}/boards', [BoardController::class, 'index']);
    Route::post('/board', [BoardController::class, 'store']);
//    Route::get('/board/{board}', [BoardController::class, 'show']);
    Route::put('/board/{board}', [BoardController::class, 'update']);
    Route::delete('/board/{board}', [BoardController::class, 'destroy']);

//    Route::get('/tickets', [TicketController::class, 'index']);
    Route::post('/ticket', [TicketController::class, 'store']);
    Route::get('/ticket/{ticket}', [TicketController::class, 'show']);
    Route::put('/ticket/{ticket}', [TicketController::class, 'update']);
    Route::delete('/ticket/{ticket}', [TicketController::class, 'destroy']);
    Route::post('/ticket/{ticket}/assign', [TicketController::class, 'assign']);
});
