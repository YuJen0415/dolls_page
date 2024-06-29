<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReactionController;

Route::get('/test', [TestController::class, 'index']);

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// 把 edit 路由放在了 {id} 路由之前，這樣 Laravel 就不會把 "edit" 誤認為是一個 ID
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');

// 新增貼文
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

// 留言
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::post('/posts/{post}/reactions', [ReactionController::class, 'toggle'])->name('reactions.toggle');