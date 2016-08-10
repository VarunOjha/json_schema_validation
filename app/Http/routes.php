<?php


Route::group(['prefix'=>'v1','as'=>'UserAPIs'], function () {
Route::post('/register', ['as' => 'RegisterUserToServer', 'uses' =>'UserController@register']);
Route::post('/user/address', ['as' => 'RegisterAddressToServer', 'uses' =>'UserController@registerAddress']);
});