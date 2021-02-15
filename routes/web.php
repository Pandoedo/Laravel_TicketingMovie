<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function(){

    
    Route::get('/dashboard', 'Dashboard\DashboardController@index')->name('dashboard');


    Route::get('/dashboard/theaters', 'Dashboard\TheaterController@index')->name('dashboard.theaters');
    Route::get('/dashboard/tickets', 'Dashboard\TicketController@index')->name('dashboard.tickets');

    //Movies
    Route::get('/dashboard/movies', 'Dashboard\MovieController@index')->name('dashboard.movies');
    Route::get('/dashboard/movies/create', 'Dashboard\MovieController@create')->name('dashboard.movies.create');
    Route::post('/dashboard/movies', 'Dashboard\MovieController@store')->name('dashboard.movies.store');
    Route::get('/dashboard/movies/{movie}', 'Dashboard\MovieController@edit')->name('dashboard.movies.edit');
    Route::put('/dashboard/movies/{movie}', 'Dashboard\MovieController@update')->name('dashboard.movies.update'); //route binding
    Route::delete('/dashboard/movies/{movie}', 'Dashboard\MovieController@destroy')->name('dashboard.movies.delete');




    //User
    //#1 Route::get('/dashboard/users', 'Dashboard\UserController@index');
    //#2 Route::get('/dashboard/users', 'Dashboard\UserController@index')->name('dashboard.users');
    Route::get('/dashboard/users', 'Dashboard\UserController@index')->name('dashboard.users');
    //#1 Route::get('/dashboard/user/edit/{id}', 'Dashboard\UserController@edit');
    //#2 Route::get('/dashboard/user/edit/{id}', 'Dashboard\UserController@edit')->name('dashboard.user.edit');
    Route::get('/dashboard/users/{id}', 'Dashboard\UserController@edit')->name('dashboard.users.edit');

    //#1 Route::post('/dashboard/user/update/{id}', 'Dashboard\UserController@update');
    //#2 Route::post('/dashboard/user/update/{id}', 'Dashboard\UserController@update')->name('dashboard.user.update');
    Route::put('/dashboard/users/{id}', 'Dashboard\UserController@update')->name('dashboard.users.update');

    //1# Route::post('/dashboard/user/delete/{id}', 'Dashboard\UserController@destroy');
    //#2 Route::post('/dashboard/user/delete/{id}', 'Dashboard\UserController@destroy')->name('dashboard.user.delete');
    Route::post('/dashboard/users/{id}', 'Dashboard\UserController@destroy')->name('dashboard.users.delete');

});