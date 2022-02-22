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

/* Route::get('/', function () {
    return view('welcome');
}); */


Route::get('/', function () {
    $category = App\Models\Category::all();
    return view('welcome',['category' => $category]);
});

Route::get('getCourse/{id}', function ($id) {
    $course = App\Models\Course::where('category_id',$id)->get();
    return response()->json($course);
});