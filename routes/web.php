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

// Employees
Route::get('/admin/employees/list', 'EmployeesController@show')->name('employees.list');
Route::match(['get', 'post'], '/admin/employees/edit/{id?}', 'EmployeesController@edit')->name('employees.edit');
Route::post('/admin/employees/delete/{id}', 'EmployeesController@delete')->name('employees.delete');

// Positions
Route::get('/admin/positions/list', 'PositionController@show')->name('positions.list');
Route::match(['get', 'post'], '/admin/positions/edit/{id?}', 'PositionController@edit')->name('positions.edit');
Route::post('/admin/positions/delete/{id}', 'PositionController@delete')->name('positions.delete');

// Ajax
Route::get('/admin/employees/get-list', 'EmployeesController@getListData')->name('employees.data');
Route::get('/admin/positions/get-list', 'PositionController@getListData')->name('positions.data');
