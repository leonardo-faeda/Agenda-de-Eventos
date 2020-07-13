<?php

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





Auth::routes();

Route::get('/', 'HomeController@index')->name('admin');

Route::middleware(['auth'])->prefix('admin')->namespace('Admin')->group(function(){
    Route::resource('participareventos', 'ParticiparEventosController');
    Route::resource('listaparticipantes', 'ListaParticipantesController');
    Route::resource('eventos', 'EventosController');
    Route::resource('notificacoes', 'NotificacoesController');
});