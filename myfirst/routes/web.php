<?php

use App\Http\Controllers\addMemberController;
use App\Http\Controllers\fileUploadController;
use App\Http\Controllers\userController;
use App\Http\Controllers\userListController;
use App\Http\Controllers\UsersController;
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
    return view('welcome');
});

Route::view("about",'about');
Route::view("contact",'contact')->middleware('protected'); //added route middleware
//Route::view('login','users');
Route::view("home",'home');

Route::post('users',[UsersController::class,'getData']);

Route::view('noaccess','noaccess');

//add group of middlware
/*Route::group(['middleware'=>['protected']], function(){
    //add routes here. middleware only availabale to this route
    Route::view('login','users');
});*/

Route::get('user',[userController::class,'index']);

//check whether alreay session has a user then can't access login page without logout
Route::get('login', function () {
    if (session()->has('username')) {
        return redirect('home');
    }
    return view('users');
});

//check whether already session has a user
Route::get('logout', function () {
    if (session()->has('username')) {
        session()->pull('username');
        return redirect('login');
    }
});

Route::view('register','add');
Route::post('member',[addMemberController::class,'addMember']);

//file upload
Route::view('file','upload');
Route::post('file',[fileUploadController::class,'fileUpload']);

//profile page

Route::get('/profile/{lang}', function ($lang) {
    App::setlocale($lang);
    return view('profile');
});

//user list
Route::get('/list',[userListController::class,'getList']);

//add data user
Route::post('/addData',[userListController::class,'addData']);

//delete user
Route::get('/delete/{id}',[userListController::class,'deleteData']);

//showupdate data
Route::get('showData/{id}',[userListController::class,'showData']);

//update data
Route::post('/update',[userListController::class,'updateData']);