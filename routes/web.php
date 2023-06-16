<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EncomendaController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\Auth\ChangePasswordController;

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::get('encomendas', [EncomendaController::class, 'index'])->name('encomendas.index');

//Route::get('encomendas/create', [EncomendaController::class, 'create'])->name('encomendas.create');
//Route::post('encomendas', [EncomendaController::class, 'store'])->name('encomendas.store');

//Route::get('encomendas/{encomenda}/edit', [EncomendaController::class, 'edit'])->name('encomendas.edit');
//Route::put('encomendas/{encomenda}', [EncomendaController::class, 'update'])->name('encomendas.update');

//Route::delete('encomendas/{encomenda}', [EncomendaController::class, 'destroy'])->name('encomendas.destroy');

//Route::get('encomendas/{encomenda}', [EncomendaController::class, 'show'])->name('encomendas.show');
Route::resource('encomendas', EncomendaController::class);

Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil.index');

Route::view('/', 'home')->name('root');

//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('clientes', ClienteController::class);//->middleware('verified');

Route::resource('catalogo', CatalogoController::class);

Route::get('/password/change', [ChangePasswordController::class, 'show'])->name('password.change.show');
Route::post('/password/change', [ChangePasswordController::class, 'store'])->name('password.change.store');

Auth::routes(['verify' => true]);

Route::delete('clientes/{cliente}/photo', [ClienteController::class, 'destroy_foto'])->name('clientes.foto.destroy');


//Route::view('/', 'catalogo')->name('catalogo');