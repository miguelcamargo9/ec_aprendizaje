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