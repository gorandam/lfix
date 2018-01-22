<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{	
	return Redirect::to('login');
});


Route::resource('user', 'UsersController');
Route::post('setReminder', 'UsersController@setReminder');
Route::get('reminder/{id}', 'UsersController@dismissReminder');

// Jobs
Route::resource('jobs', 'JobsController');
Route::get('jobs/byCategory/{category}', 'JobsController@byCategory');
Route::get('jobs/{id}/open', 'JobsController@open');
Route::get('jobs/{id}/notpaid', 'JobsController@notpaid');
Route::get('jobs/{id}/archive', 'JobsController@archive');
Route::get('view-archive', 'JobsController@viewArchive');
Route::post('jobs/note', 'JobsController@note');

// Logs
Route::resource('logs', 'LogsController');

// Route::get('register', 'UsersController@create');

Route::get('login', array('as' => 'login', 'uses' => 'UsersController@login'));
Route::get('logout', array('as' => 'logout', 'uses' => 'UsersController@logout'));
Route::post('/login', array('as' => 'login', 'uses' => 'UsersController@handleLogin'));

Route::get('profiles', 'UsersController@profiles');

// Chat rooms
Route::get('/chat-rooms', array('uses' => 'ChatRoomController@getAll'));
Route::get('/chat-rooms/{chatRoom}', array('uses' => 'ChatRoomController@show'));
Route::post('/chat-rooms', array('uses' => 'ChatRoomController@create'));
// Messages
Route::get('/messages', array('uses' => 'MessageController@getByChatRoom'));
Route::post('/messages', array('uses' => 'MessageController@createInChatRoom'));
Route::get('/messages/{lastMessageId}/{chatRoom}', array('uses' => 'MessageController@getUpdates'));

Route::model('chatRoom', 'ChatRoom');