<?php

Route::post('login', ['uses' => 'apiController@login']);
Route::post('request_updates', ['uses' => 'apiController@requestUpdates']);
Route::post('download', ['uses' => 'apiController@download']);
