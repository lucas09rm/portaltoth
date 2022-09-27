<?php

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

Route::get('/admin', function () {
    return view('adm.login');
});
*/

Auth::routes();

Route::get('/teste', function () {
    return view('welcome');
});

//--------- ADMIN ---------
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.painel')->middleware('acess:adm');
Route::get('/admin/novo', [App\Http\Controllers\AdminController::class, 'create'])->name('admin.create')->middleware('acess:adm');
Route::post('/admin/do', [App\Http\Controllers\AdminController::class, 'store'])->name('admin.do')->middleware('acess:adm');

Route::get('/admin/denuncias', [App\Http\Controllers\AdminController::class, 'denuncias'])->name('admin.denuncias')->middleware('acess:adm');

//-------- USUARIO --------
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('acess:comum');

//CRUDs
Route::get('/post', [App\Http\Controllers\FeedController::class, 'createPost'])->name('post.create')->middleware('acess:cid');
Route::post('/post/do', [App\Http\Controllers\FeedController::class, 'storePost'])->name('post.do')->middleware('acess:cid');

//--------- LOGIN ---------
Route::get('/', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login/do', [App\Http\Controllers\AuthController::class, 'login'])->name('login.do');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
