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

// Route::middleware('auth:api')->get('/users', function (Request $request) {
//     return response()->json(Auth::user());
// });

Route::any('login',[ 'as' => 'login','uses'=>'ApiController@login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        // Uses first & second Middleware
        dd($request->all());
        return response()->json(Auth::user());
    });
    Route::post("delivery_notification", "ApiController@deliveryNotification");
});

Route::post('lipanampesa/success', ['as' => 'lipanampesa', 'uses' => 'ApiController@lipanampesa']);
Route::post('transactionQueryResult',['uses' =>'MpesaController@transactionQueryResult']);
Route::get('registerUrlsMpesa', ['uses' => 'TestController@registerUrlMpesa']);

Route::post('confirmTransactionUrl', ['uses' => 'C2BController@confirmUrlMpesa']);
Route::post('validateTransactionUrl', ['uses' => 'C2BController@validateUrlMpesa']);