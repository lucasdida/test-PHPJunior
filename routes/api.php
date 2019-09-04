<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('API')->name('api.')->group(function(){
	Route::prefix('calcularota')->group(function(){
        Route::get('/{origem}/{destino}/{autonomia}/{litro_combustivel}', 'RotasController@calculamelhorrota');
	});
});

