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
    return redirect('login');
});

Route::post('/login-post','Auth\LoginController@authenticate')->name('api.login');

Route::group(['middleware'=> 'auth'], function(){
# Web page route
    # Dashboard
    Route::get('/dashboard','LandingPageController@DashboardPage');

    # User
    Route::get('/user','LandingPageController@UserPage');

    # Product
    Route::get('/product','LandingPageController@ProductPage');

    # Category
    Route::get('/category','LandingPageController@CategoryPage');
});

# User Functions
    # Get all user
    Route::get('/get/users','UserController@getUsers');

    # Insert user
    Route::post('/insert/user','UserController@insertUser');

    # Update user
    Route::post('/update/user','UserController@updateUser');

    # Delete user
    Route::post('/delete/user','UserController@deleteUser');

# Product Functions
    # Get all product
    Route::get('/get/product','ProductController@getProduct');

    # Insert product
    Route::post('/insert/product','ProductController@insertProduct');

    # Update product
    Route::post('/update/product','ProductController@updateProduct');

    # Delete product
    Route::post('/delete/product','ProductController@deleteProduct');

    # Get product uploaded images
    Route::post('/get/file/attachment','ProductController@viewFileAttachment');

    # filter product by category
    Route::post('/filter/category','ProductController@filterCategory');

# Category Functions
    # Get all category
    Route::get('/get/category','CategoryController@getCategory');

    # Get all category names
    Route::get('/get/category/option','CategoryController@getCategoryOption');
    
    # Insert category
    Route::post('/insert/category','CategoryController@insertCategory');

    # Update category
    Route::post('/update/category','CategoryController@updateCategory');

    # Delete category
    Route::post('/delete/category','CategoryController@deleteCategory');
    

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/logout','Auth\LoginController@logout');
