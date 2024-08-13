<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;


Route::get('/', [AuthController::class, 'loginPage'])->name('loginPage');
Route::get('/login', [AuthController::class, 'loginPage'])->name('loginPage');
Route::get('/register', [AuthController::class, 'registerPage'])->name('registerPage');
Route::get('/login/user', [AuthController::class, 'loginUser']); //To compact login user
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/user/list', [UserController::class, 'userListPage'])->name('user.userlist');
Route::get('/user/create', [UserController::class, 'userCreatePage'])->name('user.userCreatePage');
Route::post('user/store', [UserController::class, 'createUser'])->name('user.store');


Route::get('user/profile', [ProfileController::class, 'profilePage'])->name('user.profilePage');
Route::get('user/profile/edit', [ProfileController::class, 'profileEditPage'])->name('user.profileEdit');
Route::get('/post/list', [PostController::class, 'postListPage'])->name('post.postlist');
Route::get('post/create/page', [PostController::class, 'postCreatePage'])->name('post.postCreatePage');
Route::post('/post/add', [PostController::class, 'postAdd'])->name('post.add');
Route::get('/post/edit/{id}', [PostController::class, 'postEdit'])->name('post.edit');
Route::post('posts/{post}/preview-edit', [PostController::class, 'previewEdit'])->name('post.preview');
Route::post('posts/{post}/update', [PostController::class, 'update'])->name('posts.update');

//CSV
Route::post('/posts/upload', [PostController::class, 'uploadCsv'])->name('post.upload');
Route::get('/posts/download', [PostController::class, 'downloadExcel'])->name('post.download');
