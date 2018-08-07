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
Route::get('/logout', 'Auth\LoginController@logout');
//Route::get('/home', 'HomeController@index')->name('home');

/* Routes Admin Controller */
Route::get('/admin/tutors/list', array('as' => 'admin.tutors.list', 'uses' => 'Admin\TutorsController@showListTutors'))->middleware('auth');
Route::post('/admin/tutors/getall', array('as' => 'admin.tutors.getall', 'uses' => 'Admin\TutorsController@getAllTutors'))->middleware('auth');
Route::get('/admin/tutor/view/delete/{idTutor}', array('as' => 'admin.tutor.view.delete', 'uses' => 'Admin\TutorsController@viewDeleteTutor'))->middleware('auth');
Route::post('/admin/tutor/delete', array('as' => 'admin.tutor.delete', 'uses' => 'Admin\TutorsController@deleteTutor'))->middleware('auth');
Route::get('/admin/tutor/view/edit/{idTutor}', array('as' => 'admin.tutor.view.edit', 'uses' => 'Admin\TutorsController@viewEditTutor'))->middleware('auth');
Route::post('/admin/tutor/edit', array('as' => 'admin.tutor.edit', 'uses' => 'Admin\TutorsController@editTutor'))->middleware('auth');
Route::get('/admin/tutor/view/inactivate/{idTutor}', array('as' => 'admin.tutor.view.inactivate', 'uses' => 'Admin\TutorsController@viewInactivateTutor'))->middleware('auth');
Route::post('/admin/tutor/inactivate', array('as' => 'admin.tutor.inactivate', 'uses' => 'Admin\TutorsController@inactivateTutor'))->middleware('auth');
Route::get('/admin/tutor/view/activate/{idTutor}', array('as' => 'admin.tutor.view.activate', 'uses' => 'Admin\TutorsController@viewActivateTutor'))->middleware('auth');
Route::post('/admin/tutor/activate', array('as' => 'admin.tutor.activate', 'uses' => 'Admin\TutorsController@activateTutor'))->middleware('auth');
Route::get('/admin/tutor/view/create', array('as' => 'admin.tutor.view.create', 'uses' => 'Admin\TutorsController@viewCreateTutor'))->middleware('auth');
Route::post('/admin/tutor/create', array('as' => 'admin.tutor.create', 'uses' => 'Admin\TutorsController@createTutor'))->middleware('auth');

Route::get('/admin/client/list', array('as' => 'admin.client.list', 'uses' => 'Admin\ClientsController@showListClients'))->middleware('auth');
Route::post('/admin/client/getall', array('as' => 'admin.client.getall', 'uses' => 'Admin\ClientsController@getAllClients'))->middleware('auth');
Route::get('/admin/client/view/delete/{idClient}', array('as' => 'admin.client.view.delete', 'uses' => 'Admin\ClientsController@viewDeleteClient'))->middleware('auth');
Route::post('/admin/client/delete', array('as' => 'admin.client.delete', 'uses' => 'Admin\ClientsController@deleteClient'))->middleware('auth');
Route::get('/admin/client/view/edit/{idClient}', array('as' => 'admin.client.view.edit', 'uses' => 'Admin\ClientsController@viewEditClient'))->middleware('auth');
Route::post('/admin/client/edit', array('as' => 'admin.client.edit', 'uses' => 'Admin\ClientsController@editClient'))->middleware('auth');
Route::get('/admin/client/view/create', array('as' => 'admin.client.view.create', 'uses' => 'Admin\ClientsController@viewCreateClient'))->middleware('auth');
Route::post('/admin/client/create', array('as' => 'admin.client.create', 'uses' => 'Admin\ClientsController@createClient'))->middleware('auth');

/* Routes Tickets Controller */
Route::any('/tickets/list', array('as' => 'tickets.list', 'uses' => 'Tickets\TicketsController@showListTickets'))->middleware('auth');
Route::get('/tickets/new', array('as' => 'tickets.new', 'uses' => 'Tickets\TicketsController@showNewTicket'))->middleware('auth');
Route::post('/tickets/registry', array('as' => 'tickets.registry', 'uses' => 'Tickets\TicketsController@createNewTicket'))->middleware('auth');
Route::post('/tickets/edit', array('as' => 'tickets.edit', 'uses' => 'Tickets\TicketsController@editTicket'))->middleware('auth');
Route::post('/tickets/getall', array('as' => 'tickets.getall', 'uses' => 'Tickets\TicketsController@getAllTickets'))->middleware('auth');
Route::any('/tickets/updatestate', array('as' => 'tickets.updatestate', 'uses' => 'Tickets\TicketsController@updateState'))->middleware('auth');
Route::get('/tickets/ticketinfo/{idTicket}', array('as' => 'tickets.info', 'uses' => 'Tickets\TicketsController@getInfoTickets'))->middleware('auth');
Route::post('/tickets/detalleRegistros', array('as' => 'tickets.infoRegistros', 'uses' => 'Tickets\TicketsController@getDetalleRegistros'))->middleware('auth');
Route::post('/tickets/aprobarRegistro', array('as' => 'tickets.aprobarRegistro', 'uses' => 'Tickets\TicketsController@aprobarRegistro'))->middleware('auth');

/* Routes Tutor Controller */
Route::get('/tutor/tickets/list', array('as' => 'tutor.tickets.list', 'uses' => 'Tutor\TutorsController@showListTutors'))->middleware('auth');
Route::get('/tutor/tickets/mylist', array('as' => 'tutor.tickets.mylist', 'uses' => 'Tutor\TutorsController@showMyListTutors'))->middleware('auth');
Route::post('/tutor/getall', array('as' => 'tutor.getall', 'uses' => 'Tutor\TutorsController@getAllTickets'))->middleware('auth');
Route::post('/tutor/getassigned', array('as' => 'tutor.getassigned', 'uses' => 'Tutor\TutorsController@getMyTickets'))->middleware('auth');
Route::get('/tutor/tickets/ticketinfo/{idTicket}', array('as' => 'tutor.tickets.info', 'uses' => 'Tutor\TutorsController@getInfoTickets'))->middleware('auth');
Route::post('/tutor/addcommentary', array('as' => 'tutor.commentary', 'uses' => 'Tutor\TutorsController@addCommentary'))->middleware('auth');
Route::post('/tutor/addcommentary', array('as' => 'tutor.commentary', 'uses' => 'Tutor\TutorsController@addCommentary'))->middleware('auth');
Route::get('/tutor/dateregistry', array('as' => 'tutor.dateregistry', 'uses' => 'Tutor\TutorsController@dateRegistry'))->middleware('auth');
Route::post('/tutor/guardarDoc', array('as' => 'tutor.guardar.doc', 'uses' => 'Tutor\TutorsController@guardarDocumentos'))->middleware('auth');

/*Routers Resources */
Route::post('/resources/getClients', array('as' => 'resources.getclients', 'uses' => 'Resources\ResourcesController@getClients'))->middleware('auth');
Route::post('/resources/getTutors', array('as' => 'resources.gettutors', 'uses' => 'Resources\ResourcesController@getTutors'))->middleware('auth');
Route::post('/resources/getUniversities', array('as' => 'resources.getuniversities', 'uses' => 'Resources\ResourcesController@getUniversities'))->middleware('auth');
Route::post('/resources/getDegrees', array('as' => 'resources.getdegrees', 'uses' => 'Resources\ResourcesController@getDegrees'))->middleware('auth');
Route::post('/resources/getBanks', array('as' => 'resources.getbanks', 'uses' => 'Resources\ResourcesController@getBanks'))->middleware('auth');

/* Routes Parents Controller */
Route::get('/parents/list', array('as' => 'tickets.list.parents', 'uses' => 'Parents\ParentsController@showListTickets'))->middleware('auth');
Route::get('/parents/getbyparent', array('as' => 'tickets.by.parent', 'uses' => 'Parents\ParentsController@getTicketsByParent'))->middleware('auth');
Route::get('/parents/ticketinfo/{idTicket}', array('as' => 'tickets.info', 'uses' => 'Parents\ParentsController@getInfoTickets'))->middleware('auth');
Route::post('/parents/addcommentary', array('as' => 'parent.commentary', 'uses' => 'Parents\ParentsController@addCommentary'))->middleware('auth');

/* Routes InsertInfo Controller */
Route::get('/insertinfo/clients', array('as' => 'insertinfo.clients', 'uses' => 'InsertInfo\InsertInfoController@insertClients'))->middleware('auth');
