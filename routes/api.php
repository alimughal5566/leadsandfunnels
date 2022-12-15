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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/contact/on-contact-update', function (Request $request){
    foreach ($request->all() as $req){
        $req = (object) $req;
       // Log::info(json_encode($req));
        Log::info('ChangeSource =>'. $req->changeSource);
        Log::info('propertyName =>'. $req->propertyName);
        Log::info('propertyValue =>'. $req->propertyValue);
    }

});