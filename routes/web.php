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

// ユーザープロフィール/編集画面/編集処理
Route::get('/users/{id}', 'UserController@show')->name('users.show');
Route::get('/users/edit', 'UserController@edit')->name('users.edit');
Route::patch('/users', 'UserController@update')->name('users.update');

// フォローボタン
Route::resource('follows', 'FollowController')->only([
    'store', 'destroy'
]);

//リソースルーティング
Route::resource('posts', 'PostController')->only([
    'create', 'store', 'edit', 'update', 'destroy' 
]);