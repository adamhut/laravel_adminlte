<?php

use Illuminate\Support\Facades\Auth;

Auth::loginUsingId(1);
Route::get('/', function () {
	
	$users = \App\User::all();
	return view('adminlte.pages.login',compact('users'));

});


Route::post('/login', ['as' => 'login', 'uses' => 'UserController@login']);

Route::post('forgot-password/send',  'UserController@postForgotPassword')->name('forgot-password-send');
Route::get('forgot-password/set/{token}', 'UserController@getSetForgotPassword')->name('set-forgot-password');
Route::post('forgot-password/update',  'UserController@postSetForgotPassword')->name('update-forgot-password');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'UserController@pageDashboard']);
    Route::post('do-logout', ['as' => 'logout', 'uses' => 'UserController@postLogout']);

    Route::get('user/profile', 'UserController@pageUserProfile')->name('profile');
    Route::post('user/profile',  'UserController@postUpdateProfile')->name('update-profile');
    Route::post('user/password-change', 'UserController@postHandlePasswordChange')->name('change-password');
    
    Route::get('media-manager', 'MediaController@index')->name('media-manager');
    
    Route::get('config/user/activation-pending','ActivationPendingController@index')->name('user-activation-pending');

    Route::get('config/user/import', 'AdminController@importUser')->name('import-user');
    Route::post('config/user/import', 'AdminController@handleImportUser')->name('bulk-import-user');
    Route::get('config/user/import/get-data/{uuid}', 'AdminController@getImportData')->name('get-import-data');
    //Route::get('config/user/import/persist/{uuid}', 'AdminController@PersistIncompleteData')->name('persist-incomplete-data');
});


Route::post('test', function(){

})->name('test-upload-image');