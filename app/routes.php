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

	return View::make('hello');
});

Route::get('demo',['before'=>'auth'],function(){
   
    echo "hello world";
});

Route::group(['prefix'=>'api','before'=>'oauth'],function(){
Route::resource('post','PostController');
});
Route::resource('oauth/access_token','RequestAccessTokenController');


Route::get('oauth/authorize', ['as' => 'oauth.authorize','before' => ['check-authorization-params','auth'], function() {
    // display a form where the user can authorize the client to access it's data   
   $authParams = Authorizer::getAuthCodeRequestParams();
   $formParams = array_except($authParams,'client');
   $formParams['client_id'] = $authParams['client']->getId();
   return View::make('authorization-form', ['params'=>$formParams,'client'=>$authParams['client']]);
//      $params = Authorizer::getAuthCodeRequestParams();
//      $params['user_id'] = 1;
//      $redirectUri = '';
//      $redirectUri = Authorizer::issueAuthCode('user', $params['user_id'], $params);
//      return Redirect::to($redirectUri);    
}]);

Route::post('oauth/authorize', ['as' => 'oauth.authorize.post','before' => ['csrf', 'check-authorization-params', 'auth'], function() {

    $params = Authorizer::getAuthCodeRequestParams();
    $params['user_id'] = Auth::user()->id;
    $redirectUri = '';

    // if the user has allowed the client to access its data, redirect back to the client with an auth code
    if (Input::get('approve') !== null) {
        $redirectUri = Authorizer::issueAuthCode('user', $params['user_id'], $params);
    }
    // if the user has denied the client to access its data, redirect back to the client with an error message
    if (Input::get('deny') !== null) {
        $redirectUri = Authorizer::authCodeRequestDeniedRedirectUri();
    }
    return Redirect::to($redirectUri);
}]);

Route::get('oauth2/access_token', function() {
    return Response::json(Authorizer::issueAccessToken());
});

Route::get('login',['as'=>'login','uses'=>'UserController@login']);
Route::post('login','UserController@login');