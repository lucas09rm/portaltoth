<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FiltroController;
use App\Http\Controllers\PesquisaController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

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

Route::get('/teste', [App\Http\Controllers\HomeController::class, 'teste'])->name('teste');

Route::get('/teste1', function () {
    return view('welcome');
});

//--------- LOGIN ---------
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login/do', [AuthController::class, 'login'])->name('login.do');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

//-------- USUARIO --------
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('acess:comum');

Route::get('/senha', [HomeController::class, 'editSenha'])->name('edit.senha')->middleware('acess:comum');
Route::patch('/senha/do', [HomeController::class, 'updateSenha'])->name('update.senha')->middleware('acess:comum');

Route::get('/alterar', [HomeController::class, 'edit'])->name('edit.perfil')->middleware('acess:comum');
Route::patch('/alterar/cidadao/do', [HomeController::class, 'updateCidadao'])->name('update.cidadao')->middleware('acess:cid');
Route::patch('/alterar/empresa/do', [HomeController::class, 'updateEmpresa'])->name('update.empresa')->middleware('acess:emp');

Route::get('/infos', [HomeController::class, 'infos'])->name('infos')->middleware('acess:comum');
Route::get('/vagas', [HomeController::class, 'vagas'])->name('vagas')->middleware('acess:comum');
Route::get('/perfil', [HomeController::class, 'perfil'])->name('perfil')->middleware('acess:comum');

Route::post('/denunciar', [FeedController::class, 'denunciarPost'])->name('denunciar.post')->middleware('acess:cid');

//CRUDs
Route::get('/post', [FeedController::class, 'createPost'])->name('feed.createPost')->middleware('acess:cid');
Route::post('/post/do', [FeedController::class, 'storePost'])->name('feed.storePost')->middleware('acess:cid');
Route::delete('/excluirPost', [FeedController::class, 'destroyPost'])->name('destroy.post')->middleware('acess:cid');

Route::get('/vaga', [FeedController::class, 'createVaga'])->name('feed.createVaga')->middleware('acess:emp');
Route::post('/vaga/do', [FeedController::class, 'storeVaga'])->name('feed.storeVaga')->middleware('acess:emp');
Route::delete('/excluirVaga', [FeedController::class, 'destroyVaga'])->name('destroy.vaga')->middleware('acess:emp');

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

Route::get('/pesquisa/post', [PesquisaController::class, 'pesquisaPost'])->name('pesquisa.post')->middleware('acess:comum');
Route::get('/pesquisa/info', [PesquisaController::class, 'pesquisaInfo'])->name('pesquisa.info')->middleware('acess:comum');
Route::get('/pesquisa/vaga', [PesquisaController::class, 'pesquisaVaga'])->name('pesquisa.vaga')->middleware('acess:comum');
Route::get('/pesquisa/perfil', [PesquisaController::class, 'pesquisaPerfil'])->name('pesquisa.perfil')->middleware('acess:comum');

Route::post('/post/data', [DataController::class, 'dataPost'])->name('post.data')->middleware('acess:comum');
Route::post('/info/data', [DataController::class, 'dataInfo'])->name('info.data')->middleware('acess:comum');
Route::post('/vaga/data', [DataController::class, 'dataVaga'])->name('vaga.data')->middleware('acess:comum');
Route::post('/perfil/data', [DataController::class, 'dataPerfil'])->name('perfil.data')->middleware('acess:comum');

//--------- ADMIN ---------
Route::get('/admin', [AdminController::class, 'index'])->name('admin.painel')->middleware('acess:adm');
Route::get('/admin/denuncias', [AdminController::class, 'denuncias'])->name('admin.denuncias')->middleware('acess:adm');

Route::get('/admin/novo', [AdminController::class, 'create'])->name('admin.create')->middleware('acess:adm');
Route::post('/admin/do', [AdminController::class, 'store'])->name('admin.do')->middleware('acess:adm');

Route::get('/admin/alterar', [AdminController::class, 'edit'])->name('admin.edit')->middleware('acess:adm');
Route::patch('/admin/alterar/do', [AdminController::class, 'update'])->name('admin.update')->middleware('acess:adm');

Route::get('/admin/senha', [AdminController::class, 'editSenha'])->name('admin.edit.senha')->middleware('acess:adm');
Route::patch('/admin/senha/do', [AdminController::class, 'updateSenha'])->name('admin.update.senha')->middleware('acess:adm');

Route::post('/admin/analise/denuncia', [AdminController::class, 'analiseDenuncia'])->name('admin.analise.denuncia')->middleware('acess:adm');

//Filtro Admin
Route::get('/admin/pesquisa/denuncia', [PesquisaController::class, 'pesquisaDenuncia'])->name('admin.pesquisa.denuncia')->middleware('acess:adm');
Route::get('/admin/pesquisa', [PesquisaController::class, 'pesquisaAdmin'])->name('admin.pesquisa')->middleware('acess:adm');

Route::post('/admin/info/data', [DataController::class, 'dataAdmin'])->name('admin.info.data')->middleware('acess:adm');
Route::post('/admin/denuncia/data', [DataController::class, 'dataDenuncia'])->name('admin.denuncia.data')->middleware('acess:adm');

//Crud Admin
Route::get('/admin/info/', [FeedController::class, 'createInfo'])->name('feed.createInfo')->middleware('acess:adm');
Route::post('/admin/info/do', [FeedController::class, 'storeInfo'])->name('feed.storeInfo')->middleware('acess:adm');

Route::delete('/admin/excluirInfo', [FeedController::class, 'destroyInfo'])->name('admin.destroy.info')->middleware('acess:adm');
