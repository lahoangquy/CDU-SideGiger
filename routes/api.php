<?php

use App\Http\Controllers\Api\ApiProjectController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\HandleApplicateController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ApiContractController;
use App\Http\Controllers\Api\ApiFileController;
use App\Http\Controllers\Api\ApiInviteController;
use App\Http\Controllers\Api\ApiMessageController;
use App\Http\Controllers\Api\ApiRequestCompleted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* Route::prefix('v1')->group(function () {
    Route::apiResource('categories', CategoryController::class);
    Route::middleware(['auth:sanctum'])->group(function () {
        // user
        Route::prefix('user')->group(function () {
            Route::get('/', function (Request $request) {
                return $request->user();
            });
            Route::put('/{user}', [UserController::class, 'update']);
            Route::post('/change-password/{user}', [UserController::class, 'updatePassword']);
            Route::get('/only-student', [UserController::class, 'getStudentUsers']);
            Route::get('/applicates/{userId}', [UserController::class, 'applicates']);
        });

        // project
        Route::get('projects/by-owner', [ApiProjectController::class, 'byOwner']);
        Route::post('projects/request-completed', [ApiRequestCompleted::class, 'store']);
        Route::prefix('projects')->group(function () {
            Route::get('/lists', [ApiProjectController::class, 'lists']);
            Route::get('{id}', [ApiProjectController::class, 'show']);
            Route::post('store', [ApiProjectController::class, 'store']);
            Route::post('storeOffer', [ApiProjectController::class, 'storeOffer']);
            Route::delete('{projectId}', [ApiProjectController::class, 'destroy']);
        });

        // Invite
        Route::prefix('invite')->group(function () {
            Route::post('/', [ApiInviteController::class, 'index']);
            Route::post('/accept-or-decline', [ApiInviteController::class, 'acceptOrDecline']);
            Route::get('/by-student/{studentId}', [ApiInviteController::class, 'byStudent']);
        });

        // contract
        Route::prefix('contracts')->group(function () {
            Route::get('/', [ApiContractController::class, 'index']);
            Route::get('/{id}', [ApiContractController::class, 'show']);
        });

        // Message
        Route::prefix('message')->group(function () {
            Route::post('/', [ApiMessageController::class, 'store']);
            Route::delete('/{message}', [ApiMessageController::class, 'destroy']);
            Route::get('/project/{message}', [ApiMessageController::class, 'byProject']);
        });

        // files
        Route::prefix('files')->group(function () {
            Route::get('/project/{projectId}', [ApiFileController::class, 'byProject']);
        });
    });

    Route::prefix('applicates')->group(function () {
        Route::post('accept/{offer}', [HandleApplicateController::class, 'accept']);
        Route::post('decine/{offer}', [HandleApplicateController::class, 'decine']);
    });
});
 */