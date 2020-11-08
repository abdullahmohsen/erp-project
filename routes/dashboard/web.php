<?php

use App\Http\Controllers\Dashboard\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){

        Route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function(){

            Route::get('/', 'WelcomeController@index')->name('welcome');

            //user routes
            Route::resource('users', 'UserController')->except(['show']);

            //category routes
            Route::resource('categories', 'CategoryController');
            // Route::get('changeStatus/{id}', 'CategoryController@changeStatus')->name('categories.status');

            //SubCategory routes
            Route::resource('subcategories', 'SubCategoryController')->except(['show']);

            //Product routes
            Route::resource('products', 'ProductCo\ntroller')->except(['show']);




        });//end of dashboard routes

    });



