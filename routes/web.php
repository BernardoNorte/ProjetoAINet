<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EncomendaController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\TshirtController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\Auth\ChangePasswordController;

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('encomendas', [EncomendaController::class, 'index'])->name('encomendas.index');

Route::get('encomendas/create', [EncomendaController::class, 'create'])->name('encomendas.create');
Route::post('encomendas', [EncomendaController::class, 'store'])->name('encomendas.store');

Route::get('encomendas/{encomenda}/edit', [EncomendaController::class, 'edit'])->name('encomendas.edit');
Route::put('encomendas/{encomenda}', [EncomendaController::class, 'update'])->name('encomendas.update');

Route::get('encomendas/{encomenda}/show', [EncomendaController::class, 'show'])->name('encomendas.show');
//Route::resource('encomendas', EncomendaController::class);

Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil.index');

Route::view('/', 'home')->name('root');

//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('users', UserController::class);

Route::resource('clientes', ClienteController::class);//->middleware('verified');

Route::resource('catalogo', CatalogoController::class);

Route::get('/catalogo', [App\Http\Controllers\CatalogoController::class, 'index'])->name('catalogo.index');
Route::get('/catalogo/search', 'CatalogoController@search')->name('catalogo.search');
Route::get('/catalogo/{id}', 'CatalogoController@show')->name('catalogo.show');

Route::get('/password/change', [ChangePasswordController::class, 'show'])->name('password.change.show');
Route::post('/password/change', [ChangePasswordController::class, 'store'])->name('password.change.store');

Auth::routes(['verify' => true]);

Route::delete('clientes/{cliente}/photo', [ClienteController::class, 'destroy_foto'])->name('clientes.foto.destroy');
Route::delete('users/{user}/photo', [UserController::class, 'destroy_foto'])->name('users.foto.destroy');
Route::delete('catalogo/{estampa}/image', [CatalogoController::class, 'destroy_image'])->name('estampas.image.destroy');


Route::get('tshirts', [TshirtController::class, 'index'])->name('tshirts.index');


Route::middleware('usar-carrinho')->group(function () {
    Route::get('cart', [CarrinhoController::class, 'show'])->name('cart.show');
    Route::post('cart', [CarrinhoController::class, 'store'])->name('cart.store');
    Route::delete('cart', [CarrinhoController::class, 'destroy'])->name('cart.destroy');
    Route::put('cart/{estampa}', [CarrinhoController::class, 'updateCart'])->name('cart.update');
    Route::post('cart/{estampa}', [CarrinhoController::class, 'addToCart'])->name('cart.add');
    Route::delete('cart/{estampa}/{size}', [CarrinhoController::class, 'destroyCartTshirt'])->name('cart.remove');
});

Route::get('encomendas/minhas', [EncomendaController::class, 'minhasEncomendas'])->name('encomendas.minhas');

Route::get('/encomendas/{encomenda}/pdf', [PdfController::class, 'index'])->name('pdf.index');



//Route::view('/', 'catalogo')->name('catalogo');





//Route::view('/', 'catalogo')->name('catalogo');
