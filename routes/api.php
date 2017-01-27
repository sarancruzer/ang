<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');



Route::group(["middleware"=>"cors"], function(){

			

			Route::post('authenticate', 'AuthenticateController@authenticate');


Route::group(["middleware"=>"jwt.auth"], function(){

			
			Route::post('getUsers', 'AuthenticateController@getUsers');		

			Route::post('getSupplierList', 'SupplierController@getSupplierList');		
			Route::post('addSupplier', 'SupplierController@addSupplier');		
			Route::post('editSupplier', 'SupplierController@editSupplier');
			Route::post('updateSupplier', 'SupplierController@updateSupplier');		
			Route::post('deleteSupplier', 'SupplierController@deleteSupplier');

			Route::post('getProductList', 'ProductController@getProductList');		
			Route::post('addProduct', 'ProductController@addProduct');		
			Route::post('editProduct', 'ProductController@editProduct');
			Route::post('updateProduct', 'ProductController@updateProduct');		
			Route::post('deleteProduct', 'ProductController@deleteProduct');		

			Route::post('productInward', 'ProductController@productInward');	

			Route::post('profile', 'AuthenticateController@profile');	

			
			
			
			
			

		
});

});