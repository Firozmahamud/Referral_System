<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
    // return view('welcome');
    return redirect('/login');
});

Route::group(['middleware'=> ['is_login']],function () {
    Route::get('/register',[UserController::class,'loadregister'])->name('register');
    Route::post('/user-registered',[UserController::class,'registered'])->name('registered');
    Route::get('/referral-register',[UserController::class,'loadreferralregister'])->name('referralregister');
    Route::get('/email-verification/{token}',[UserController::class,'emailverification'])->name('emailverification');


    // Route::get('/error',[UserController::class,'loadreferralregister'])->name('404');


    Route::get('/login',[UserController::class,'loadlogin'])->name('login');
    Route::post('/login',[UserController::class,'userlogin'])->name('userlogin');

});

Route::group(['middleware'=> ['is_logout']],function () {

    Route::get('/dashboard', [UserController::class,'loaddashboard'])->name('dashboard');
    Route::get('/referralTrack', [UserController::class,'loadreferralTrack'])->name('referralTrack');
    Route::get('/delete-account', [UserController::class,'deleteAccount'])->name('deleteAccount');

    Route::get('/logout', [UserController::class,'logout'])->name('logout');


});

