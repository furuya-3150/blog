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

//Route::get('/', function () {
//    return view('welcome');
//});
Auth::routes();

//User ログイン後
Route::group(['middleware' => 'auth:user'], function() {
	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('/item/review/create/{item_id}', 'ItemController@reviewCreate')->name('review.create');
	Route::post('/item/review/create', 'ItemController@reviewCreateRecieve')->name('review.createRecieve');
	Route::get('/item/review/edit/{item_id}', 'ItemController@reviewEdit')->name('review.edit');
	Route::post('/item/review/edit', 'ItemController@reviewEditRecieve')->name('review.editRecieve');
	Route::get('/cart/index', 'CartController@index')->name('cart.index');
	Route::get('/cart/index/{cart_id}', 'CartController@delete')->name('cart.delete');
	Route::post('/cart/index/{totals}', 'PaymentController@payment')->name('payment');
	Route::post('/detail/{id}', 'CartController@add')->name('cart.add');
	Route::get('/addressee/index', 'AddresseeController@index')->name('addressee.index');
	Route::post('/addressee/create', 'AddresseeController@create')->name('addressee.create');
	Route::view('/addressee/create', 'addressee.create')->name('addressee.view.create');
	Route::get('/addressee/edit/{addressee_id}', 'AddresseeController@edit')->name('addressee.edit');
	Route::post('/addressee/edit/{addressee_id}', 'AddresseeController@update')->name('addressee.update');
	Route::get('/addressee/delete/{addressee_id}', 'AddresseeController@delete')->name('addressee.delete');
	Route::get('/addressee/select', 'AddresseeController@select')->name('addressee.select');
	Route::post('/addressee/register', 'AddresseeController@registerAddressee')->name('addressee.register');
	Route::get('/user/edit/{user_id}', 'UserController@edit')->name('user.edit');
	Route::post('/user/edit', 'UserController@update')->name('user.update');
	Route::get('/user/reset/{token}', 'UserController@reset')->name('user.reset');
	Route::get('/purchase_history/index', 'OrderCancellationController@index')->name('purcahse_history.index');
	Route::get('/purchase_history/refund/{id}', 'OrderCancellationController@refund')->name('purcahse_history.refund');
});


//Admin 認証不要
Route::group(['prefix' => 'admin'], function() {
	Route::get('/', function () { return redirect('/admin/home'); });
	Route::get('login', 'Admin\LoginController@showLoginForm')->name('admin.login');
	Route::post('login', 'Admin\LoginController@login');
});

//Admin ログイン後
Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function() {
	Route::post('logout', 'Admin\LoginController@logout')->name('admin.logout');
	Route::get('home', 'Admin\HomeController@index')->name('admin.home');
	Route::get('index', 'Admin\ItemController@index')->name('admin.index');
	Route::get('item/csv', 'Admin\ItemController@csvExport')->name('admin.item.export_csv');
	Route::get('detail/{id}', 'Admin\ItemController@detail')->name('admin.detail');
	Route::get('create', 'Admin\ItemController@create')->name('admin.create');
	Route::post('create', 'Admin\ItemController@createReceive')->name('admin.createReceive');
	Route::get('edit/{id}', 'Admin\ItemController@edit')->name('admin.edit');
	Route::post('update/{id}', 'Admin\ItemController@update')->name('admin.update');
	Route::get('user/index', 'Admin\UserController@index')->name('admin.user.index');
	Route::get('user/detail/{id}', 'Admin\UserController@detail')->name('admin.user.detail');
	Route::get('order/index', 'Admin\OrderController@index')->name('admin.order.index');
	Route::get('order/detail/{id}', 'Admin\OrderController@detail')->name('admin.order.detail');
	Route::get('order/refund/{id}', 'Admin\OrderController@refund')->name('admin.order.refund');
	Route::get('order/in_delivary/{id}', 'Admin\OrderController@inDelivary')->name('admin.order.in_delivary');
	Route::get('order/delivared_at/{id}', 'Admin\OrderController@delivared')->name('admin.order.delivared');
	Route::post('order/index', 'Admin\OrderController@search')->name('admin.order.search');
	Route::get('order/csv', 'Admin\OrderController@csvExport')->name('admin.order.export_csv');
	Route::get('contact/index', 'Admin\ContactController@index')->name('admin.contact.index');
	Route::get('contact/detail/{id}', 'Admin\ContactController@detail')->name('admin.contact.detail');
	Route::get('data/index', 'Admin\DataController@index')->name('admin.data.index');
	Route::post('data/csv', 'Admin\DataController@importCsv')->name('admin.data.import_csv');
});

//ログイン不要
Route::get('/', 'ItemController@index')->name('item.index');
Route::get('/detail/{id}', 'ItemController@show')->name('detail.show');
Route::get('contact/index', 'ContactController@index')->name('contact.index');
Route::post('contact/confirm', 'ContactController@confirm')->name('contact.confirm');
Route::post('contact/thanks', 'ContactController@send')->name('contact.send');
