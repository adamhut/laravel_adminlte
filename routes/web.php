<?php

use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
/*

*/
Auth::loginUsingId(1);
Route::get('/', function () {
	
  
	$users = \App\User::all();
	return view('adminlte.pages.login',compact('users'));

});

Route::get('test', function () {

    //$role = Role::create(['name' => 'admin']);
    auth()->user()->assignRole('admin');
    //$permission = Permission::create(['name' => 'edit articles']);
    //$users = \App\User::all();
    //return view('adminlte.pages.login',compact('users'));

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
    //
    //TODO Need to implement
    Route::get('config', 'AdminController@getConfigPage')->name('config');
    Route::get('config/user/roles', 'AdminController@getManageRoles')->name('manage-roles');
    Route::post('config/user/role-save', 'AdminController@postSaveRoles')->name('save-role');

    Route::get('config/user/permissions', ['as' => 'manage-permissions', 'uses' => 'AdminController@getManagePermission']);
    Route::post('config/user/permission-save', ['as' => 'save-permission', 'uses' => 'AdminController@postSavePermission']);
    Route::get('config/user/permission/{id}', ['as' => 'edit-permission', 'uses' => 'AdminController@getEditPermission']);
    Route::post('config/user/permission/update', ['as' => 'update-permission', 'uses' => 'AdminController@postUpdatePermission']);

    Route::get('config/system/my-activities', ['as' => 'my-activities', 'uses' => 'UserController@pageMyActivities']);
    Route::get('config/system/activities', ['as' => 'activities', 'uses' => 'WatchdogController@getWatchdogPage']);
    Route::get('config/system/settings', ['as' => 'settings', 'uses' => 'AdminController@getSettingsPage']);
    Route::post('config/system/settings', ['as' => 'settings-save', 'uses' => 'AdminController@postHandleSettingsPageSave']);
    Route::post('config/system/settings-add', ['as' => 'settings-add', 'uses' => 'AdminController@postHandleSettingsPageAdd']);
});


Route::post('test', function(){

})->name('test-upload-image');