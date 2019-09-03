<?php

Route::get('/', ['uses' => 'lendingController@index', 'as' => 'index']);


Route::get('logout', ['uses' =>  'authController@logout', 'as' => 'logout']);

Route::group(['middleware' => 'forms'], function (){
    Route::post('login', ['uses' => 'authController@login', 'as' => 'form_login']);
    Route::post('register', ['uses' => 'authController@register', 'as' => 'form_register']);
});

Route::get('dashboard', ['uses' =>  'dashboardController@index', 'as' => 'dashboard']);
Route::get('download/{id}', ['uses' => 'dashboardController@download', 'middleware' => 'action'])->where(['game_id' => '[0-9+]']);

Route::get('confirm/{token}', ['uses' => 'mailController@confirm', 'as' => 'confirm_email']);

Route::group(['prefix' => 'action', 'middleware' => 'action'], function (){
    Route::post('change_password', ['uses' => 'actionController@changePassword', 'as' => 'change_password']);
    Route::post('activate_promo', ['uses' => 'actionController@activatePromo', 'as' => 'activate_promo']);

    Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function (){
        Route::post('new_cheat', ['uses' => 'adminActionController@createCheat', 'as' => 'new_cheat']);
        Route::post('get_info', ['uses' => 'adminActionController@getInfo', 'as' => 'get_info']);
        Route::post('update_cheat', ['uses' => 'adminActionController@updateCheat', 'as' => 'update_cheat']);
        Route::post('generate_promo', ['uses' => 'adminActionController@generatePromo', 'as' => 'generate_promo']);
    });
});
