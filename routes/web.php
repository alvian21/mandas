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
    return redirect('defect');
});

Route::get('/defect/chart','DefectController@chart')->name('defect.chart');
Route::resource('defect', 'DefectController');


Route::get('/chart/mpsactual','MpsActualController@chart')->name('mpsactual.chart');
Route::resource('mpsactual', 'MpsActualController');

