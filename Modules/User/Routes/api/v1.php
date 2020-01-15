<?php

use Illuminate\Support\Facades\Route;

// Auth routes
Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', 'Auth\\LoginController@login');
    Route::post('/logout', 'Auth\\LoginController@logout');
    Route::post('/refresh', 'Auth\\LoginController@refresh');
    Route::get('/me', 'Auth\\LoginController@me');
});

// Email verification
//Route::group(['middleware' => 'transactional'], function () {
//    Route::post('/email/resend', 'Auth\\VerificationController@resend')->name('verification.resend');
//    Route::get('/email/verify/{id}', 'Auth\\VerificationController@verify')->name('verification.verify');
//
//    Route::post('/password/reset', 'Auth\ResetPasswordController@reset');
//
//    Route::post('/users', 'UserController@store');
//});
//
//// Password verification
//Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
//Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
