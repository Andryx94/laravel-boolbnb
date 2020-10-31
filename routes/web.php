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

//HOMEPAGE
Route::get('/', 'HomepageController@index')->name('homepage');
//pagina dei creatori
Route::view('/creators', 'creators.index')->name('creators.index');

//routes gruppo ADMIN
Auth::routes();
Route::prefix('admin')
->namespace('Admin')
->middleware('auth')
->name('admin.')
->group(function () {

  //CRUD appartamenti
  Route::resource('apartments', 'ApartmentController');

  //modifica e aggiornamenti immagini appartamenti
  Route::get('apartments/{apartment}/edit_photo', 'ApartmentController@editPhoto')
  ->name('apartments.edit_photo');
  Route::put('apartments/{apartment}/update_photo', 'ApartmentController@updatePhoto')
  ->name('apartments.update_photo');

  //pannello statistiche
  Route::get('/statistics', 'StatisticController@index')
  ->name('statistics.index');
  Route::get('/statistics/{apartment}', 'StatisticController@show')
  ->name('statistics.show');

  //pannello messaggi ricevuti
  Route::get('/messages', 'EmailController@index')
  ->name('messages.index');
  Route::get('/messages/{apartment}', 'EmailController@show')
  ->name('messages.show');

  //pannello pagamenti
  Route::resource('/sponsorships', 'SponsorshipController');
});

//routes gruppo GUEST
Route::namespace('Guest')
->name('guest.')
->group(function() {

  //lista e dettaglio appartamenti
  Route::get('/apartments', 'ApartmentController@index')
  ->name('apartments.index');
  Route::get('/apartments/{apartment}', 'ApartmentController@show')
  ->name('apartments.show');

  //invio email al database
  Route::get('/apartments/{apartment}/show', 'EmailController@create')
  ->name('apartments.show');
  Route::post('/apartments/{apartment}', 'EmailController@store')
  ->name('apartments.store');

});
