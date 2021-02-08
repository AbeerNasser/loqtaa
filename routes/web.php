<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth\login');
});

Auth::routes(['register'=>false]);

Route::middleware(['role:admin|super_admin|support|auditor'])->group(function()
{
    Route::get('/home', 'HomeController@index')->name('home');
});

Route::prefix('Dashboard')->middleware(['role:admin|super_admin'])->group(function()
{
    Route::resource('/cats', 'dashboard\catsController');
    Route::resource('/ads', 'dashboard\adsController');
    Route::resource('/users', 'dashboard\userController');
    Route::resource('/admins', 'dashboard\adminController');
    Route::resource('/settings', 'dashboard\settingController');
});

Route::prefix('Dashboard')->middleware(['role:admin|super_admin|support'])->group(function()
{
    Route::resource('/stores', 'dashboard\StoreController');
    Route::get('/activeStore/{id}', 'dashboard\StoreController@activeStore');
    Route::get('/storOffers/{id}', 'dashboard\StoreController@storOffers');
    Route::resource('/storeOffers', 'dashboard\StoreOffersController');
    Route::get('/activeOffer/{id}', 'dashboard\StoreOffersController@activeOffer');
    Route::resource('/salesReps', 'dashboard\salesRepsController');
    Route::get('/activeDelegate/{id}', 'dashboard\salesRepsController@activeDelegate');
});
