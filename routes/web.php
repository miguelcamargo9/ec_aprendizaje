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

/* Routes Tickets Controller */
Route::any('/tickets/list', array('as' => 'tickets.list', 'uses' => 'Tickets\TicketsController@showListTickets'))->middleware('auth');
Route::get('/tickets/new', array('as' => 'tickets.new', 'uses' => 'Tickets\TicketsController@showNewTicket'))->middleware('auth');
Route::post('/tickets/registry', array('as' => 'tickets.registry', 'uses' => 'Tickets\TicketsController@createNewTicket'))->middleware('auth');
Route::post('/tickets/edit', array('as' => 'tickets.edit', 'uses' => 'Tickets\TicketsController@editTicket'))->middleware('auth');
Route::post('/tickets/getall', array('as' => 'tickets.getall', 'uses' => 'Tickets\TicketsController@getAllTickets'))->middleware('auth');
Route::any('/tickets/updatestate', array('as' => 'tickets.updatestate', 'uses' => 'Tickets\TicketsController@updateState'))->middleware('auth');
Route::get('/tickets/ticketinfo/{idTicket}', array('as' => 'tickets.info', 'uses' => 'Tickets\TicketsController@getInfoTickets'))->middleware('auth');
Route::post('/tickets/detalleRegistros', array('as' => 'tickets.infoRegistros', 'uses' => 'Tickets\TicketsController@getDetalleRegistros'))->middleware('auth');

/* Routes Tutor Controller */
Route::get('/tutor/tickets/list', array('as' => 'tutor.tickets.list', 'uses' => 'Tutor\TutorsController@showListTutors'))->middleware('auth');
Route::get('/tutor/tickets/mylist', array('as' => 'tutor.tickets.mylist', 'uses' => 'Tutor\TutorsController@showMyListTutors'))->middleware('auth');
Route::post('/tutor/getall', array('as' => 'tutor.getall', 'uses' => 'Tutor\TutorsController@getAllTickets'))->middleware('auth');
Route::post('/tutor/getassigned', array('as' => 'tutor.getassigned', 'uses' => 'Tutor\TutorsController@getMyTickets'))->middleware('auth');
Route::get('/tutor/tickets/ticketinfo/{idTicket}', array('as' => 'tutor.tickets.info', 'uses' => 'Tutor\TutorsController@getInfoTickets'))->middleware('auth');
Route::post('/tutor/addcommentary', array('as' => 'tutor.commentary', 'uses' => 'Tutor\TutorsController@addCommentary'))->middleware('auth');

/*Routers Resources */
Route::post('/resources/getClients', array('as' => 'resources.getclients', 'uses' => 'Resources\ResourcesController@getClients'))->middleware('auth');
Route::post('/resources/getTutors', array('as' => 'resources.gettutors', 'uses' => 'Resources\ResourcesController@getTutors'))->middleware('auth');

/* Routes Parents Controller */
Route::get('/parents/list', array('as' => 'tickets.list.parents', 'uses' => 'Parents\ParentsController@showListTickets'))->middleware('auth');
Route::get('/parents/getbyparent', array('as' => 'tickets.by.parent', 'uses' => 'Parents\ParentsController@getTicketsByParent'))->middleware('auth');
Route::get('/parents/ticketinfo/{idTicket}', array('as' => 'tickets.info', 'uses' => 'Parents\ParentsController@getInfoTickets'))->middleware('auth');
Route::post('/parents/addcommentary', array('as' => 'parent.commentary', 'uses' => 'Parents\ParentsController@addCommentary'))->middleware('auth');
