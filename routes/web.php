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
Route::post('user/confirm', [UserController::class, 'confirmPage'])->name('user.confirm');


Route::get('user/profile', [ProfileController::class, 'profilePage'])->name('user.profilePage');
Route::get('user/profile/edit', [ProfileController::class, 'profileEditPage'])->name('user.profileEdit');
Route::get('/post/list', [PostController::class, 'postListPage'])->name('post.postlist');
Route::get('post/create/page', [PostController::class, 'postCreatePage'])->name('post.postCreatePage');
Route::post('/post/add', [PostController::class, 'postAdd'])->name('post.add');

//CSV
Route::post('/posts/upload', [PostController::class, 'uploadCsv'])->name('post.upload');
Route::get('/posts/download', [PostController::class, 'downloadExcel'])->name('post.download');
