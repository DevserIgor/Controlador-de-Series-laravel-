<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

//rotas de series
Route::get('/series', 'SeriesController@index')->name('series.index');
Route::get('/series/criar', 'SeriesController@create')->name('series.create')->middleware('autenticador');
Route::post('/series/criar', 'SeriesController@store')->name('series.store')->middleware('autenticador');
Route::delete('/series/{id}', 'SeriesController@destroy')->name('series.delete')->middleware('autenticador');
Route::post('/series/{id}/editaNome', 'SeriesController@editaNome')->middleware('autenticador');

//rotas de temporadas
Route::get('/series/{id}/temporadas', 'TemporadasController@index');

//rotas de episodios
Route::get('/temporadas/{temporada}/episodios', 'EpisodiosController@index');
Route::post('/temporadas/{temporada}/episodios/assistir', 'EpisodiosController@assistir')->middleware('autenticador');

//rota de login
Route::get('/entrar', 'EntrarController@index')->name("entrar");
Route::post('/entrar', 'EntrarController@entrar');

Route::get('/registrar', 'RegistroController@create');
Route::post('/registrar', 'RegistroController@store');

//logout
Route::get('/sair', function(){
    \Illuminate\Support\Facades\Auth::logout();
    return redirect('/entrar');
});

//roda de email
Route::get('/visualizando-email', function(){
    return new App\Mail\NovaSerie(
        "Arrow",
        "Qtd.Temporadas",
        "Qtd.Episodios"
    );
});

Route::get('/enviando-email', function(){
    $email = new \App\Mail\NovaSerie(
        "Arrow",
        5,
        10
    );

    $email->subject = 'Nova Série Adicionada';

    $user = (object)[
        'email' => 'iprates22@gmail.com',
        'name' => 'igor'
    ];

    Mail::to($user)->send($email);
    return "Email enviado";
});



