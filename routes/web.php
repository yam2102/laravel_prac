<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Auth\AuthController;
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

// ログイン画面を表示
Route::get('/auth', [AuthController::class, 'showLogin'])->name('showLogin');
// ログイン処理
Route::post('/login', [AuthController::class, 'login'])->name('login');

// ブログ一覧画面を表示
Route::get('/', [BlogController::class, 'showList'])->name('blogs');

// ブログ登録画面を表示
Route::get('/blog/create', [BlogController::class, 'showCreate'])->name('create');

// ブログ登録
Route::post('/blog/store', [BlogController::class, 'exeStore'])->name('store');

// ブログ編集画面を表示
Route::get('/blog/edit/{id}', [BlogController::class, 'showEdit'])->name('edit');

// ブログ更新
Route::post('/blog/update', [BlogController::class, 'exeUpdate'])->name('update');

// ブログ削除
Route::post('/blog/delete/{id}', [BlogController::class, 'exeDelete'])->name('delete');

// ブログ詳細画面を表示
Route::get('/blog/{id}', [BlogController::class, 'showDetail'])->name('show');
