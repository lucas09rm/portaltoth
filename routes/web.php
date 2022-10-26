<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FiltroController;
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

Route::get('/teste1', function () {
    return view('welcome');
});


//-------- USUARIO --------
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('acess:comum');

Route::get('/senha', [App\Http\Controllers\HomeController::class, 'editSenha'])->name('edit.senha')->middleware('acess:comum');
Route::patch('/senha/do', [App\Http\Controllers\HomeController::class, 'updateSenha'])->name('update.senha')->middleware('acess:comum');

Route::get('/alterar', [App\Http\Controllers\HomeController::class, 'edit'])->name('edit.perfil')->middleware('acess:comum');
Route::patch('/alterar/cidadao/do', [App\Http\Controllers\HomeController::class, 'updateCidadao'])->name('update.cidadao')->middleware('acess:cid');
Route::patch('/alterar/empresa/do', [App\Http\Controllers\HomeController::class, 'updateEmpresa'])->name('update.empresa')->middleware('acess:emp');

Route::get('/infos', [App\Http\Controllers\HomeController::class, 'infos'])->name('infos')->middleware('acess:comum');
Route::get('/vagas', [App\Http\Controllers\HomeController::class, 'vagas'])->name('vagas')->middleware('acess:comum');
Route::get('/perfil', [App\Http\Controllers\HomeController::class, 'perfil'])->name('perfil')->middleware('acess:comum');

Route::get('/teste', [App\Http\Controllers\HomeController::class, 'teste'])->name('teste');

//CRUDs
Route::get('/post', [App\Http\Controllers\FeedController::class, 'createPost'])->name('feed.createPost')->middleware('acess:cid');
Route::post('/post/do', [App\Http\Controllers\FeedController::class, 'storePost'])->name('feed.storePost')->middleware('acess:cid');

Route::get('/vaga', [App\Http\Controllers\FeedController::class, 'createVaga'])->name('feed.createVaga')->middleware('acess:emp');
Route::post('/vaga/do', [App\Http\Controllers\FeedController::class, 'storeVaga'])->name('feed.storeVaga')->middleware('acess:emp');

Route::delete('/admin/excluirInfo', [App\Http\Controllers\FeedController::class, 'destroyInfo'])->name('admin.destroy.info')->middleware('acess:adm');
Route::delete('/admin/excluirPost', [App\Http\Controllers\FeedController::class, 'destroyPost'])->name('destroy.post')->middleware('acess:cid');
Route::delete('/admin/excluirVaga', [App\Http\Controllers\FeedController::class, 'destroyVaga'])->name('destroy.vaga')->middleware('acess:emp');

//--------- LOGIN ---------
Route::get('/', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login/do', [App\Http\Controllers\AuthController::class, 'login'])->name('login.do');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

//--------- ADMIN ---------
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.painel')->middleware('acess:adm');
Route::get('/admin/novo', [App\Http\Controllers\AdminController::class, 'create'])->name('admin.create')->middleware('acess:adm');
Route::post('/admin/do', [App\Http\Controllers\AdminController::class, 'store'])->name('admin.do')->middleware('acess:adm');

Route::get('/admin/alterar', [App\Http\Controllers\AdminController::class, 'edit'])->name('admin.edit')->middleware('acess:adm');
Route::patch('/admin/alterar/do', [App\Http\Controllers\AdminController::class, 'update'])->name('admin.update')->middleware('acess:adm');

Route::get('/admin/senha', [App\Http\Controllers\AdminController::class, 'editSenha'])->name('admin.edit.senha')->middleware('acess:adm');
Route::patch('/admin/senha/do', [App\Http\Controllers\AdminController::class, 'updateSenha'])->name('admin.update.senha')->middleware('acess:adm');

Route::get('/admin/denuncias', [App\Http\Controllers\AdminController::class, 'denuncias'])->name('admin.denuncias')->middleware('acess:adm');

Route::get('/admin/info/', [App\Http\Controllers\FeedController::class, 'createInfo'])->name('feed.createInfo')->middleware('acess:adm');
Route::post('/admin/info/do', [App\Http\Controllers\FeedController::class, 'storeInfo'])->name('feed.storeInfo')->middleware('acess:adm');

Route::get('/admin/pesquisa', [FiltroController::class, 'pesquisaAdmin'])->name('admin.pesquisa')->middleware('acess:adm');
Route::get('/admin/pesquisa/denuncia', [FiltroController::class, 'pesquisaDenuncia'])->name('admin.pesquisa.denuncia')->middleware('acess:adm');

//--------- FILTRO ---------
Route::get('/noticias', [FiltroController::class, 'noticias'])->name('noticias')->middleware('acess:comum');
Route::get('/eventos', [FiltroController::class, 'eventos'])->name('eventos')->middleware('acess:comum');
Route::get('/promocoes', [FiltroController::class, 'promocoes'])->name('promocoes')->middleware('acess:comum');
Route::get('/inauguracoes', [FiltroController::class, 'inauguracoes'])->name('inauguracoes')->middleware('acess:comum');

Route::get('/historia', [FiltroController::class, 'historia'])->name('historia')->middleware('acess:comum');
Route::get('/voluntariar', [FiltroController::class, 'voluntariar'])->name('voluntariar')->middleware('acess:comum');
Route::get('/projetos', [FiltroController::class, 'projetos'])->name('projetos')->middleware('acess:comum');
Route::get('/infosRegiao', [FiltroController::class, 'infosRegiao'])->name('infosRegiao')->middleware('acess:comum');

Route::get('/candidatos', [FiltroController::class, 'candidatos'])->name('candidatos')->middleware('acess:comum');

Route::get('/pesquisa/post', [FiltroController::class, 'pesquisaPost'])->name('pesquisa.post')->middleware('acess:comum');
Route::get('/pesquisa/info', [FiltroController::class, 'pesquisaInfo'])->name('pesquisa.info')->middleware('acess:comum');
Route::get('/pesquisa/vaga', [FiltroController::class, 'pesquisaVaga'])->name('pesquisa.vaga')->middleware('acess:comum');
Route::get('/pesquisa/perfil', [FiltroController::class, 'pesquisaPerfil'])->name('pesquisa.perfil')->middleware('acess:comum');