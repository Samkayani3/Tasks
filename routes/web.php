<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\PostController;


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

 Route::get('/test', function () {
     return view('testing');
 });

// Route::get('/',[TaskController::class,'index']);

// Route::post('/add-task',[TaskController::class,'AddTask']);

// Route::post('post-sortable',[PostController::class,'update']);

Route::get('/',[PostController::class,'index']);
Route::post('/add-task',[PostController::class,'AddTask']);
Route::post('post-sortable',[PostController::class,'update']);
Route::get('/edit-task/{id}',[PostController::class,'editTask']);
Route::put('/update-task/{id}',[PostController::class,'updateTask']);
Route::delete('/delete-task/{id}',[PostController::class,'deleteTask']);



