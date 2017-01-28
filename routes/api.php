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
			Route::post('supplierAdd', 'SupplierController@supplierAdd');		
			Route::post('getSupplierById/{id}', 'SupplierController@getSupplierById');
			Route::post('supplierUpdate', 'SupplierController@supplierUpdate');		
			Route::post('supplierDelete', 'SupplierController@supplierDelete');

			Route::post('getProductList', 'ProductController@getProductList');		
			Route::post('productAdd', 'ProductController@addProduct');		
			Route::post('getProductById', 'ProductController@getProductById');
			Route::post('productUpdate', 'ProductController@productUpdate');		
			Route::post('productDelete', 'ProductController@productDelete');		
			Route::post('getAllSuppliers', 'ProductController@getAllSuppliers');		
			

			Route::post('productInward', 'ProductController@productInward');	

			Route::post('profile', 'AuthenticateController@profile');	

			
			
			
			
			

		
});

});