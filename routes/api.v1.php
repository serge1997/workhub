<?php

use App\Http\Controllers\AnnexController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentResponseController;
use App\Http\Controllers\CustomColumnController;
use App\Http\Controllers\CustomColumnsValueController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SprintController;
use App\Http\Controllers\SubTaskController;
use App\Http\Controllers\TaskActivityController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskExecutionStatusController;
use App\Http\Controllers\TaskRoadMapController;
use App\Http\Controllers\TeamSpaceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Resources\UserResource;
use App\Models\CommentResponse;
use App\Http\Controllers\BiController;
use Illuminate\Database\Query\Builder;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

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

Route::get('/test', function() {
    $results = Task::select('sp.id', 'sp.name', DB::raw('IF(COUNT(tasks.id) > 1,COUNT(tasks.id) ,0) as total_tasks'))
        ->withoutGlobalScopes()
            ->from('tasks as tasks')
                ->addSelect(['concluded' => Task::selectRaw('IF(COUNT(t2.id),COUNT(t2.id) , 0)')
                    ->from('tasks as t2')
                        ->whereColumn([
                            ['tasks.project_id', 't2.project_id'],
                            ['tasks.sprint_id', 't2.sprint_id'],
                        ])
                            ->where([
                                ['t2.execution_status_id', 8],
                                ['t2.deleted_at', null]
                            ])
                                ->groupBy('t2.sprint_id')
                ])
                ->join('sprints as sp', 'sp.id', '=', 'tasks.sprint_id')
                    ->where([
                        ['tasks.project_id', 1],
                        ['tasks.deleted_at', null]
                    ])
                        ->groupBy('sp.id', 'sp.name', 'tasks.project_id', 'tasks.sprint_id')
                            ->orderBy('tasks.sprint_id', 'DESC')
                                ->get();

    dd($results);
    // $results = $tasks->groupBy(function(\App\Models\Task $task) {
    //     if ($task->isConcluded()){
    //         return "Concluded";
    //     }
    //     if ($task->isNotConcluded()){
    //         return "Not concluded";
    //     }
    // });
});
Route::middleware('auth:sanctum')->group(function() {

    Route::controller(BiController::class)->group(function(){
        Route::prefix('bi')->name('bi.')->group(function(){
            Route::get('/count-task-by-sprints/project/{project_id}', 'listCountTaskbySprintsProject')->whereNumber('project_id');
            Route::get('/list-sprint-status-count/by-project/{project_id}', 'listTaskExcutionStatusByProjectSprint')->whereNumber('project_id');
            Route::get('/list-concluded-not/by-sprint/{sprint_id}', 'listConcludedAndNot')->whereNumber('sprint_id');
        });
    });

    Route::controller(SubTaskController::class)->group(function(){
        Route::prefix('sub-task')->name('sub_task')->group(function(){
            Route::post('/', 'store')->name('store');
            Route::get('/list-by-parent', 'listByParent')->name('list.by.parent');
            Route::delete('/detach/{id}', 'detach')->name('detach')->whereNumber('id');
        });
    });

    Route::controller(TeamSpaceController::class)->group(function(){
        Route::prefix('team-space')->name('team-space.')->group(function(){
            Route::post('/', 'store')->name('store');
            Route::get('/', 'index')->name('index');
            Route::get('/{id}', 'show')->name('show')->whereNumber('id');
            Route::put('/', 'update')->name('update');
            Route::delete('/{id}', 'delete')->name('delete')->whereNumber('id');
        });
    });

    Route::controller(ProjectController::class)->group(function() {
        Route::prefix('project')->name('project.')->group(function(){
            Route::post('/', 'store')->name('store');
            Route::get('/', 'index')->name('index');
            Route::get('/list-by-team-space/{team_id}', 'listByTeamSpace')->name('list.by.teamspace');
        });
    });
    Route::controller(UserController::class)->group(function() {
        Route::post('user', 'OnCreate');
        Route::get('users', 'OnListAll');
        Route::post('user-avatar', 'OnCreateAvatar');
        Route::get('user-search', 'OnSearch')->name('user.search');
        Route::get('user/list-by-poject/{project_id}', 'getByProject')->name('list.by.project')->whereNumber('project_id');
    });

    Route::controller(TaskController::class)->group(function() {
        Route::name('task.')->group(function(){
            Route::post('task', 'onCreate');
            Route::get('tasks', 'onListAll');
            Route::get('task', 'onFind');
            Route::put('task/execution-status', 'onHandleExecutionStatus');
            Route::delete('task', 'onSoftDelete')->name('task.delete');
            Route::get('task-by-user', 'onListByAuthUser');
            Route::get('task-by-filtered-user', 'onListByFilteredUser');
            Route::get('tasks/by-sprint', 'onListBySprint');
            Route::get('tasks/list-by-project/{project_id}', 'getByProject')->name('tasks.list.by.project')->whereNumber('project_id');
            Route::put('task/priority', 'updatePriority')->name('task.update.priority');
            Route::put('task/user', 'updateUser')->name('task.update.user');
            Route::get('tasks/sprint/{sprint_id}/project/{project_id}', 'getAllBySprintAndProject')->name('list.by.sprint.project');
            Route::get('tasks/list-backlogs-by-project/{project_id}', 'getAllBacklogsByProject')->name('list.backlogs.by.project')->whereNumber('project_id');
            Route::get('task/list-by-project/{project_id}/status/{status_id}', 'listAllTaskByProjectAndStatus')->whereNumber(['project_id', 'status_id']);
            Route::post('task/list-by-ids', 'listAllByTasksIds')->name('list.by.ids');
            Route::put('task/transfert', 'transfert')->name('transfert');
        });
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
            Route::get('/task', 'onListByTaskId');
        });
    });

    Route::controller(CustomColumnsValueController::class)->group(function(){
        Route::get('custom-column-value', 'onFindByTask');
        Route::put('custom-column-value', 'onUpdate');
        Route::post('custom-column-value/task', 'onCreateByTask');
    });

    Route::controller(TaskRoadMapController::class)->group(function() {
        Route::prefix('task-road-map')->group(function() {
            Route::post('/', 'onCreate');
        });
    });

    Route::controller(AnnexController::class)->group(function(){
        Route::prefix('annex')->group(function(){
            Route::post('/', 'onCreate');
        });
    });

    Route::controller(SprintController::class)->group(function() {
        Route::prefix('sprint')->name('sprint.')->group(function() {
            Route::post('/', 'onCreate')->name('store');
            Route::get('/', 'onListAll')->name('index');
            Route::get('/list-by-project/{project_id}', 'getAllByProject')->name('list.by.project')->whereNumber('project_id');
        });
    });

    Route::controller(TaskExecutionStatusController::class)->group(function(){
        Route::prefix('task-execution-status')->group(function(){
            Route::get('/', 'onListAll');
            Route::get('/list-task-by-project/{project_id}', 'listByProjectWithTaskCount')->name('list.by.task.project')->whereNumber('project_id');
            Route::get('/list-task-quantity-by-sprint/{sprint_id}', 'listCountBySprint')->whereNumber('sprint_id');
        });
    });

    Route::controller(TaskActivityController::class)->group(function(){
        Route::prefix('task-activity')->name('task.activity.')->group(function(){
            Route::get('/by-task-executor', 'onNotifyByTaskExecutor');
            Route::put('/readed', 'onMarkAsReaded');
            Route::get('/list-by-task/{id}', 'listByTaskId')->name('list.by.task');
        });
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

