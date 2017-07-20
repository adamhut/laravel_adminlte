<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function () {
    Route::post('sidebar-toggle', 'Api\UserApiController@postSidebarToggle');
    Route::post('image-upload', 'Api\UserApiController@postUploadProfilePic');
    
    Route::delete('user/{user}', 'ActivationPendingController@destroy');

    Route::get('get-media', 'Api\MediaUploadController@index');
    Route::post('media-upload', 'Api\MediaUploadController@store');

    Route::get('watchdog-entries', 'Api\UserApiController@getUserWatchdogEntries');

    //Route::get('persist-users/{uuid}' );
    Route::get('persist-import/{uuid}', 'Api\AdminApiController@PersistIncompleteData')->name('persist-incomplete-data');
    Route::get('edit-users/{uuid}', 'Api\AdminApiController@editWrongUsers')->name('edit-wrong-user');

    
});