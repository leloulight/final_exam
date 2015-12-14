<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['as' => 'getLogin', 'uses' => 'Auth\AuthController@getLogin'] );


// Authentication routes...
Route::get('auth/login',  ['as' => 'getLogin', 'uses' => 'Auth\AuthController@getLogin']);
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');


Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
	// Department
    Route::resource('department', 'DepartmentController');
    Route::get('list', ['as' => 'admin.department.listDep', 'uses' => 'DepartmentController@listDep']);
    Route::post('savePdf', ['as' => 'savePdf', 'uses' => 'DepartmentController@savePdf']);
    Route::get('saveExcel', ['as' => 'saveExcel', 'uses' => 'DepartmentController@saveExcel']);

    // Staff
    Route::resource('staff','StaffController');
    Route::get('change-pass/{id}',['as' => 'admin.staff.getChange', 'uses' => 'StaffController@getChange']);
    Route::post('change-pass/{id}',['as' => 'admin.staff.postChange', 'uses' => 'StaffController@postChange']);
    
    //Review
    Route::resource('review', 'ReviewController');
    Route::get('add-colnum', ['as' => 'addColnum', 'uses' => 'ReviewController@addColnum']);
    
    //Level
    Route::resource('level', 'LevelController');
    Route::get('edit-review/{idReview}/{idStaff}',['as' => 'admin.review.editReview', 'uses' => 'ReviewController@editReview']);
    Route::resource('team', 'TeamController');

    // Position
    Route::resource('position', 'PositionController');
});

Route::any('{all}', function () {
    return view('errors.503');
});
Route::any('admin/{all}', function () {
    return view('errors.503');
});
