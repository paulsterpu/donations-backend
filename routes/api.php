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

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('/my_account_details', 'AccountController@accountDetails');
    Route::post('/logout', 'LoginController@logout');
    Route::post('/base64_profile_picture', 'AccountController@base64ProfilePicture');
    Route::get('/base_64_profile_picture', 'AccountController@getBase64ProfilePicture');
    Route::post('/donation', 'DonationsController@createDonationOffer');

    Route::get('/profile_picture', 'AccountController@getProfilePicture');
    Route::post('/profile_picture', 'AccountController@profilePicture');


});

Route::get('/category', 'CategoryController@getDonationsForCategory');

Route::post('/register', 'RegistrationController@postRegister');
Route::get('/activate/{email}/{activationCode}', 'ActivationController@activate');
Route::post('/resend_activation/', 'ActivationController@resendActivation');

Route::get('/donations', 'DonationsController@getDonations');
Route::get('/donations_count', 'DonationsController@getDonationsCount');

Route::get('/picture', 'GetPicturesController@getDonationPicture');

Route::get('/test', 'LoginController@testInternalReq');
Route::get('/test_curl', 'LoginController@testCurl');
Route::post('/testing_post', 'LoginController@testingPost');

Route::post('/login', 'LoginController@postLogin');
Route::group([

    'middleware' => ['api']

], function () {

    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});
