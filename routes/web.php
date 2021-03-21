<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

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

Route::get('login', [LoginController::class, 'show'])->name('login');
Route::post('login', [LoginController::class, 'authenticate']);
Route::post('logout', [LoginController::class, 'logout']);
Route::post('posts', [PostController::class, 'submit']);
Route::post('posts/{postId}/like', [PostController::class, 'like']);
Route::middleware('auth')->get('admin', [AdminController::class, 'show']);
Route::middleware('auth')->post('admin/posts/{postId}/approval', [AdminController::class, 'approval']);
Route::middleware('auth')->post('admin/posts/{postId}/hide', [AdminController::class, 'hide']);
Route::get('/', [HomeController::class, 'show']);
Route::get('{locale}', [HomeController::class, 'show']);
