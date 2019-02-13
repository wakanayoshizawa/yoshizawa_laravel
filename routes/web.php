<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Task;
use Illuminate\Http\Request;

/*Route::get('/', function () {
    return view('welcome');
});*/

/**
 * 全タスク表示
 */
Route::get('/', function () {
    $tasks = Task::select('tasks.id', 'tasks.name', 'users.id as user_id', 'users.name as user_name')
        ->leftJoin('users', 'tasks.user_id', '=', 'users.id')
        ->orderBy('tasks.created_at', 'asc')->get();

    return view('tasks', [
        'tasks' => $tasks
    ]);
});

/**
 * 新タスク追加
 */
Route::post('/task', function (Request $request) {
    if (!Auth::check()) {
        return redirect('/login');
    }
    $user = Auth::user();

    $validator = Validator::make($request->all(), [
        //'name' => 'required|max:255',
        'name' => 'required|max:191',
    ]);

    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }

    $task = new Task;
    $task->name = $request->name;
    $task->user_id = $user->id;
    $task->save();

    return redirect('/');
});

/**
 * 既存タスク削除
 */
Route::delete('/task/{id}', function ($id) {
    if (!Auth::check()) {
        return redirect('/login');
    }

    Task::findOrFail($id)->delete();

    return redirect('/');
});

/**
 * 既存タスク変更
 */
Route::put('/task/{id}', function (Request $request, $id) {
    if (!Auth::check()) {
        return redirect('/login');
    }
    $user = Auth::user();

    $validator = Validator::make($request->all(), [
        //'name' => 'required|max:255',
        'name' => 'required|max:191',
    ]);

    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }

    $task = Task::where('id', $id)->first();
    $task->name = $request->name;
    $task->user_id = $user->id;
    $task->save();

    return redirect('/');
});

/**
 * 変更タスク表示
 */
Route::get('/task_update/{id}', function ($id) {
    if (!Auth::check()) {
        return redirect('/login');
    }

    $task = Task::where('id', $id)->first();

    return view('tasks_update', [
        'task' => $task
    ]);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
