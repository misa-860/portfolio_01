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

// トップページ：投稿一覧
Route::get('/', 'PostController@index')->name('posts.index');
// Route::get('/', function () {
//     return view('welcome');
// });

// ログイン関連のルーティング
Auth::routes();

//リソースルーティング
Route::resource('posts', 'PostController')->only([
    'create', 'store', 'edit', 'update', 'destroy' 
]);