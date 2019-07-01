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


Auth::routes();

Route::redirect('/', '/admin/employees/list');
Route::get('/admin/employees/list', 'EmployeesController@showList')->name('employees.list');
Route::match(['get', 'post'], '/admin/employees/edit/{id?}', 'EmployeesController@edit')->name('employees.edit');
Route::post('/admin/employees/delete/{id}', 'EmployeesController@delete')->name('employees.delete');

Route::get('/admin/positions/list', 'PositionController@showList')->name('positions.list');
Route::match(['get', 'post'], '/admin/positions/edit/{id?}', 'PositionController@edit')->name('positions.edit');

// Ajax
Route::get('/admin/employees/get-list', 'EmployeesController@getListData')->name('employees.data');
Route::get('/admin/positions/get-list', 'PositionController@getListData')->name('positions.data');
