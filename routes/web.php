<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SendMailController;

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

Route::get('/', function () {
    return view('welcome');
});

// Queues and jobs

Route::get('send/mail', [SendMailController::class, 'send_mail'])->name('send_mail');
Route::get('email-test', function(){
	$details['email'] = 'mhrabid558@gmail.com';
    dispatch(new App\Jobs\SendEmailTest($details));
    dd('done');

});

// End Queues and jobs

Route::prefix('admin')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::group(['middleware' => ['auth','admin']], function () {
        Route::post('/mark-as-read', [App\Http\Controllers\HomeController::class, 'markNotification'])->name('markNotification');
        Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
        Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
        Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
        Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@profileUpdate']);
        Route::get('upgrade', function () {
            return view('pages.upgrade');
        })->name('upgrade');
        Route::get('map', function () {
            return view('pages.maps');
        })->name('map');
        Route::get('icons', function () {
            return view('pages.icons');
        })->name('icons');
        Route::get('table-list', function () {
            return view('pages.tables');
        })->name('table');
        Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
    });
});

// Route::get('php-info', function () {
//     return phpinfo();
// });
