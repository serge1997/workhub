<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentResponseController;
use App\Http\Controllers\CustomColumnController;
use App\Http\Controllers\CustomColumnsValueController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Resources\UserResource;
use App\Models\CommentResponse;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()
        ->json(new UserResource($request->user()));
});

Route::middleware('auth:sanctum')->group(function() {

    Route::controller(UserController::class)->group(function() {
        Route::post('user', 'OnCreate');
        Route::get('users', 'OnListAll');
        Route::post('user-avatar', 'OnCreateAvatar');
    });

    Route::controller(TaskController::class)->group(function() {
        Route::post('task', 'onCreate');
        Route::get('tasks', 'onListAll');
        Route::get('task', 'onFind');
        Route::put('task/execution-status', 'onHandleExecutionStatus');
    });

    Route::controller(FollowerController::class)->group(function() {
        Route::prefix('followers')->group(function() {
            Route::get('/', 'onListAllByTask');
        });
    });

    Route::controller(CommentController::class)->group(function() {
        Route::get('comment', 'onFind')->name('comment.find');
        Route::put('comment', 'onSoftDelete')->name('comment.softdelete');
        Route::put("comment-content", "onUpdate");
        Route::prefix("comments")->group(function() {
            Route::post("/", "onCreate");
            Route::get("/", "onListAllByTask");
            Route::get('/soft-deleted', "onListAllSoftDeleted");
            Route::put('/refresh/{comment_id?}', 'onRefreshSoftDelete');
        });
    });

    Route::controller(CommentResponseController::class)->group(function() {
        Route::prefix("comment-response")->group(function() {
            Route::post("/", "onCreate");
            Route::get("/", "onListAllByComment");
            Route::get('/response', 'onFind')->name('find.comment.response');
            Route::put('/', 'onUpdate');
            Route::delete('/{response_id?}/{comment_id?}', 'onUpdate');
        });
    });

    Route::controller(CustomColumnController::class)->group(function(){
        Route::prefix('custom-column')->group(function(){
            Route::post('/', 'onCreate');
            Route::get('/', 'onListAll');
        });
    });

    Route::controller(CustomColumnsValueController::class)->group(function(){
        Route::get('custom-column-value', 'onFindByTask');
    });

    Route::controller(PositionController::class)->group(function() {
        Route::get('positions', 'OnListAll');
    });

    Route::controller(DepartmentController::class)->group(function(){
        Route::get('departments', 'OnListAll');
    });
});

Route::controller(LoginController::class)->group(function(){
    Route::post('login', 'loginAction');
    Route::post('logout', 'logOutAction')->middleware('auth:sanctum');
});

