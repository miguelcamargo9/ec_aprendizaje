<?php

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

/* Routes Home Controller */
Route::get('/', array('as' => 'home', 'uses' => 'HomeController@index'))->middleware('auth');
Route::get('/index', array('as' => 'index', 'uses' => 'HomeController@index'))->middleware('auth');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

/* Routes Admin Controller */
Route::get('/admin/tutors/list', array('as' => 'admin.tutors.list', 'uses' => 'Admin\TutorsController@showListTutors'))->middleware('auth');


Route::any('/tickets/list', array('as' => 'tickets.list', 'uses' => 'Tickets\TicketsController@showListTickets'))->middleware('auth');
Route::get('/tickets/new', array('as' => 'tickets.new', 'uses' => 'Tickets\TicketsController@showNewTicket'))->middleware('auth');
Route::post('/tickets/registry', array('as' => 'tickets.registry', 'uses' => 'Tickets\TicketsController@createNewTicket'))->middleware('auth');
Route::post('/tickets/edit', array('as' => 'tickets.edit', 'uses' => 'Tickets\TicketsController@editTicket'))->middleware('auth');
Route::post('/tickets/getall', array('as' => 'tickets.getall', 'uses' => 'Tickets\TicketsController@getAllTickets'))->middleware('auth');
Route::any('/tickets/updatestate', array('as' => 'tickets.updatestate', 'uses' => 'Tickets\TicketsController@updateState'))->middleware('auth');

