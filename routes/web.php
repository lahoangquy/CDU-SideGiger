<?php

use App\Http\Controllers\Api\ApiConfirmationCompleted;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UploadController;
use App\Mail\SendConfirmedOfferingStatusMail;
use App\Models\ProjectOffer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiProjectController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\HandleApplicateController;
use App\Http\Controllers\Api\ApiContractController;
use App\Http\Controllers\Api\ApiFileController;
use App\Http\Controllers\Api\ApiInviteController;
use App\Http\Controllers\Api\ApiMessageController;
use App\Http\Controllers\Api\ApiRequestCompleted;
use Illuminate\Http\Request;

// Route::get('test-mail', function () {
//     $offer = ProjectOffer::find(1);
//     return new SendConfirmedOfferingStatusMail($offer, 'approved');
// });



Auth::routes(['verify' => true]);
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['guest'])->post('login', [UserController::class, 'login']);
Route::middleware(['auth'])->post('logout', [UserController::class, 'logout']);
Route::middleware(['guest'])->post('register', [UserController::class, 'register']);

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function () {
    Route::get('setting', [StaffController::class, 'contactInfo']);
    Route::get('profile', [StaffController::class, 'myProfile']);
    Route::view('manage-contract', 'front-end.staff.contracts')->name('dashboard.manage.contract');
    Route::get('contract/{contract}', [ContractController::class, 'show'])->name('dashboard.show.contract');
});

// For only student
Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'role:' . User::TASKER_ROLE]], function () {
    Route::get('invited', [StudentController::class, 'listProjectInvited'])->name('student.project.invited');
    Route::get('applicated', [StudentController::class, 'listProjectApplicated'])->name('student.project.apllicated');
});

Route::middleware(['auth', 'role:' . User::POSTER_ROLE])
    ->prefix('staff')
    ->group(function () {
        Route::get('/manage-project', [StaffController::class, 'dashboard'])->name('staff.manage.project');
    });

Route::group(['middleware' => 'auth'], function () {
    Route::get('tasks', [TaskController::class, 'index'])->name('task');
    Route::get('tasks/proposal/{id}', [TaskController::class, 'proprosal'])->name('task.proposal');
});


Route::middleware(['auth'])->group(function () {
    // Upload
    Route::post('upload', [UploadController::class, 'index']);
    Route::post('removeFile', [UploadController::class, 'remove']);
});


// Admin area
Route::middleware(['auth', 'role:admin'])->prefix('admin')
    ->group(function () {
        // put admin's routes here
    });



Route::apiResource('categories', CategoryController::class);
Route::middleware(['auth'])->group(function () {
    // user
    Route::prefix('user')->group(function () {
        Route::get('/', function (Request $request) {
            return $request->user();
        });
        Route::post('{user}', [UserController::class, 'update']);
        Route::post('change-password/{user}', [UserController::class, 'updatePassword']);
        Route::get('only-student', [UserController::class, 'getStudentUsers']);
        Route::get('applicates/{userId}', [UserController::class, 'applicates']);
        Route::get('{user}', [UserController::class, 'show']);
    });

    // project
    Route::prefix('projects')->group(function () {
        Route::get('lists', [ApiProjectController::class, 'lists']);
        Route::get('by-owner', [ApiProjectController::class, 'byOwner']);
        Route::get('{id}', [ApiProjectController::class, 'show']);
        Route::post('store', [ApiProjectController::class, 'store']);
        Route::post('update/{projectId}', [ApiProjectController::class, 'update']);
        Route::post('storeOffer', [ApiProjectController::class, 'storeOffer']);
        Route::post('request-completed', [ApiRequestCompleted::class, 'store']);
        Route::post('confirmation-completed', [ApiConfirmationCompleted::class, 'store']);
        Route::post('delete/{projectId}', [ApiProjectController::class, 'destroy']);
    });

    // Invite
    Route::prefix('invite')->group(function () {
        Route::post('/', [ApiInviteController::class, 'index']);
        Route::post('accept-or-decline', [ApiInviteController::class, 'acceptOrDecline']);
        Route::get('by-student/{studentId}', [ApiInviteController::class, 'byStudent']);
    });

    // contract
    Route::prefix('contracts')->group(function () {
        Route::get('/', [ApiContractController::class, 'index']);
        Route::get('{id}', [ApiContractController::class, 'show']);
        Route::post('feedback/{contractId}', [ApiContractController::class, 'feedback']);
    });

    // Message
    Route::prefix('message')->group(function () {
        Route::post('/', [ApiMessageController::class, 'store']);
        Route::post('delete/{message}', [ApiMessageController::class, 'destroy']);
        Route::get('project/{message}', [ApiMessageController::class, 'byProject']);
    });

    // files
    Route::prefix('files')->group(function () {
        Route::get('project/{projectId}', [ApiFileController::class, 'byProject']);
    });
});

Route::prefix('applicates')->group(function () {
    Route::post('accept/{offer}', [HandleApplicateController::class, 'accept']);
    Route::post('decine/{offer}', [HandleApplicateController::class, 'decine']);
});
