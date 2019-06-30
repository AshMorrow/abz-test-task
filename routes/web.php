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
Route::get('/admin/employees/list', 'EmployeesController@showList')->name('employees');
Route::get('/admin/employees/edit/{id}', 'EmployeesController@edit')->name('employees.edit');

// Ajax
Route::get('/admin/employees/get-list', 'EmployeesController@getListData')->name('employees.data');
