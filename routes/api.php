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

Route::middleware('auth:api')->get('/user', function (Request $request) {    return $request->user();});




Route::post('/admin/post/delete', ['as' => 'post.delete.api', 'uses' => 'PostsController@deletePost']);
Route::post('/test-upload/', ['as' => 'test.upload', 'uses' => 'TestController@testUpload']);
Route::get('/lang/{lang_type}', ['as' => 'lang.data', 'uses' => 'TestController@getLangData']);
Route::post('/Translation/store', ['as' => 'lang.data', 'uses' => 'TestController@storeTranslationData']);
// Route::get('/todos', 'TodoController');
//Route::get('todos', 'TodoController')->middleware('auth:api');

/*Route::post('todos', function(Request $request) {
    return Article::create($request->all);
});*/

/*common module for all data */

Route::get('common/roles', 'Api\CommonController@roles');
Route::get('common/country', 'Api\CommonController@country');
Route::get('common/timezone', 'Api\CommonController@timezone');
Route::get('common/page', 'Api\CommonController@page');
Route::get('common/job-status', 'Api\CommonController@jobstatus');
Route::get('common/applicant-status', 'Api\CommonController@applicantstatus');
Route::get('common/exp/min-max', 'Api\CommonController@minMaxExperience');
Route::get('common/inoutstatus', 'Api\CommonController@inoutStatus');

/*common module for all data */

Route::post('login', 'Api\UsersController@apiLogin');
Route::post('login/token', [  'uses' => 'Auth\CustomAccessTokenController@issueUserToken']);
Route::post('users/register', 'Api\UsersController@register');
Route::get('users/check-email-exists', 'Api\UsersController@checkEmailExists');
Route::get('users/logout', 'Api\UsersController@logout')->middleware('auth:api');



Route::get('email-code/verify', 'UsersController@verifyEmailCode');
Route::post('users/forgot-password', 'UsersController@forgotPassword');
Route::post('users/send-verification-mail', 'UsersController@sendVerificationEmail');
Route::post('users/reset-password', 'UsersController@resetPassword');
Route::get('users/get-info', 'UsersController@getUserInfo');


Route::group(['prefix' => 'users', 'middleware' => ['auth:api']], function() {
    Route::put('avatar/{id}', 'UsersController@updateUserAvatar');
});

Route::group(['prefix' => 'business', 'middleware' => ['auth:api']], function() 
{
	Route::get('jobs', 'BusinessController@getJobs');// get All Job List
    Route::get('jobs/checkin', 'BusinessController@checkin');// pending checkin job list
	Route::get('get-single-job', 'BusinessController@getSingleJobs');// get All Job List
	Route::post('add-new-job', 'BusinessController@storeJob');// add new Jobs
	Route::get('get-job-applicant', 'BusinessController@getJobApplicant');// get All Job List
	Route::post('confirm-applicant', 'BusinessController@confirmApplicant');// confirm or reject applicant
    Route::get('get-applicant-detail', 'BusinessController@getJobApplicantDetails');// get job applicant details
	Route::put('update-single-job', 'BusinessController@updateSingleJob');// update signle Jobs
	Route::delete('job-delete', 'BusinessController@deleteJob'); //delete jobs
	
	//address
	Route::get('addresses', 'BusinessController@getAllAddress');// get All Address List
	Route::post('addresses', 'BusinessController@addAddress');// Add Address
	Route::get('addresses/{address_id}', 'BusinessController@getAddressById'); //  edit address
	Route::put('addresses/{address_id}', 'BusinessController@updateAddress');//update address
	Route::delete('addresses/{address_id}', 'BusinessController@deleteAddress');// delete Address
	//address
	
	//checkin checkout
	Route::get('inoutstatus/job/{job_id}/user/{user_id}', 'BusinessController@inoutstatus');// check in out status
    Route::post('inoutstatus/job/{job_id}/user/{user_id}/manualcheckin', 'BusinessController@manualcheckin');//manual check in
    Route::post('inoutstatus/job/{job_id}/user/{user_id}/manualcheckout', 'BusinessController@manualcheckout');// manual check in
    Route::post('checkinupdate/job/{job_id}/user/{user_id}', 'BusinessController@checkinupdate');// check in for job
    Route::post('checkoutupdate/job/{job_id}/user/{user_id}', 'BusinessController@checkoutupdate');// check out for job
	//checkin checkout

    //cards
    Route::get('cards', 'CardsController@getAllCards');// get All card List
    Route::post('cards', 'CardsController@addCard');// Add new cards
    Route::get('cards/default', 'CardsController@getDefaultCard');
    Route::get('cards/{card_id}', 'CardsController@getCardById'); //  edit cards
    Route::put('cards/{card_id}', 'CardsController@updateCard');//update cards
    Route::delete('cards/{card_id}', 'CardsController@deleteCard');// delete cards
    //cards

    //payment
	Route::post('payments', 'BusinessController@addmoneytowallet');// add money to wallet
    //payment
    Route::get('ratings', 'RatingsController@staffRating');// get Rating
    Route::post('ratings/job/{job_id}/user/{user_id}', 'RatingsController@ratingToStaff');// submit Rating

    Route::get('{business_id}', ['as' => 'business.show', 'uses' => 'BusinessController@show']);//get Profile details
    Route::put('{business_id}', ['as' => 'business.update', 'uses' => 'BusinessController@update']); //update business
    Route::put('preference/{business_id}', ['as' => 'business.update.preference', 'uses' => 'BusinessController@updateBusinessPreference']);
	
});

Route::group(['prefix' => 'staff', 'middleware' => ['auth:api']], function() {
	
	Route::get('jobs', 'StaffController@getJobs');// get All Posted Job from business
    Route::get('jobs/applied', 'StaffController@myApplyJob');// get All My applied Job
    Route::get('jobs/{job_id}', 'StaffController@getSingleJobDetails');// get single job details
	Route::post('jobs/apply/{job_id}', 'StaffController@applyJob');// apply Job


    Route::put('bank-accounts/', 'StaffController@updateBankAccount');// update Bank account
    //bank accounts
    Route::get('bank-accounts', 'BankAccountsController@getAllAccounts');// get All account List
    Route::post('bank-accounts', 'BankAccountsController@addAccount');// Add new account
    Route::get('bank-accounts/default', 'BankAccountsController@getDefaultAccount');//default account details
    Route::get('bank-accounts/{account_id}', 'BankAccountsController@getAcountById'); //  edit account
    Route::put('bank-accounts/{account_id}', 'BankAccountsController@updateAccount');//update account
    Route::delete('bank-accounts/{account_id}', 'BankAccountsController@deleteAccount');// delete account
    //bank accounts

    Route::get('ratings', 'RatingsController@clientRating');// get Rating
    Route::post('ratings/job/{job_id}', 'RatingsController@ratingToClient');// submit Rating
	//checkin checkout
	Route::get('inoutstatus/jobs/{job_id}', 'StaffController@inoutstatus');// check in out status
    Route::post('inoutstatus/jobs/{job_id}/checkin', 'StaffController@checkin');// update check in  status
    Route::post('inoutstatus/jobs/{job_id}/checkout', 'StaffController@checkout');// update out  status
	//checkin checkout
	
	//job titles
	Route::get('jobtitles', 'StaffController@getJobSkills')->middleware('auth:api'); //staff job title and skills 
	Route::post('jobtitles', 'StaffController@addskills')->middleware('auth:api');// add staff skills api 
	Route::get('jobtitles/{id}', 'StaffController@getSingleJobSkills')->middleware('auth:api'); //staff single title and skills
	Route::put('jobtitles/{id}', 'StaffController@updateskills')->middleware('auth:api'); // update 
	Route::delete('jobtitles/{id}', 'StaffController@deleteJobSkills')->middleware('auth:api'); //delete jobtitle
	//job titles
    Route::put('availability',  'StaffController@availability');// is online  availability
    Route::get('{staff_id}', ['as' => 'staff.show', 'uses' => 'StaffController@show']);
    Route::put('{staff_id}', ['as' => 'staff.update', 'uses' => 'StaffController@update']);
    Route::put('preference/{staff_id}', ['as' => 'staff.update.preference', 'uses' => 'BusinessController@updateStaffPreference']);
});


//Route::get('staff/{staff_id}/job-skills/edit', ['as' => 'staff.get.jobskills', 'uses' => 'StaffController@editStaffJobSkill']);

	


Route::delete('staff/{staff_id}/job-skills', ['as' => 'staff.delete.jobskills', 'uses' => 'JobTitlesController@deleteStaffJobTitleWithSkills']);


Route::post('business/{business_id}/photo', ['as' => 'staff.photoupload', 'uses' => 'UploadHandlerController@uploadBusinessPhoto']);
Route::post('staff/{staff_id}/photo', ['as' => 'staff.photoupload', 'uses' => 'UploadHandlerController@savePostedFiles']);

Route::get('common/uploadphoto', ['as' => 'upload_photo', 'uses' => 'common\common\UploadPhoto@getAction']);
Route::post('common/uploadphoto', ['as' => 'upload_photo', 'uses' => 'common\common\UploadPhoto@postAction']);

Route::get('job-titles', 'JobTitlesController@getJobTitles')->middleware('auth:api');
Route::get('job-titles/{job_title_id}/skills', 'JobTitlesController@getJobTitles')->middleware('auth:api');
Route::get('job-titles-skills', 'JobTitlesController@getJobTitlesSkillas')->middleware('auth:api');
Route::get('skills', 'ObjSkillsController@index');

Route::get('settings/{setting_obj}', ['as' => 'settings.obj', 'uses' => 'SettingsController@show']);
// -- routes for testing purpose ----

Route::get('defaults/cards/store', 'UsersController@storeCard');
Route::get('defaults', 'DefaultsController@index');
Route::get('faqs', 'FaqsController@getPublishedFaqs');
Route::get('policy', 'SysSettingsController@getPolicy');
Route::get('countries', 'CountryController@index')->middleware('auth:api');
Route::get('countries/{id}', 'CountryController@show')->middleware('auth:api');


Route::get('timezones', 'TimezoneController@index')->middleware('auth:api');
Route::get('timezones/{id}', 'TimezoneController@show')->middleware('auth:api');

Route::get('todos', 'TodoController@index')->middleware('auth:api');
Route::get('todos/{id}', 'TodoController@show')->middleware('auth:api');
Route::post('todos', 'TodoController@store')->middleware('auth:api');
Route::put('todos/{id}', 'TodoController@update')->middleware('auth:api');
Route::delete('todos/{id}', 'TodoController@delete')->middleware('auth:api');

Route::get('users-list', 'TestController@getUsersList');
Route::post('add-country','TestController@addCountry');
Route::put('update-country','TestController@updateCountry');
Route::delete('delete-country/{id}','TestController@deleteCountry');
Route::get('fetch-staff-skills/{id}','TestController@fetchStaffSkills');
Route::get('fetch-staff-job-skills/{id}','TestController@fetchStaffJobSkill');




Route::get('jobs', 'JobController@index')->middleware('auth:api');
Route::get('jobs/{id}', 'JobController@show')->middleware('auth:api');
Route::post('jobs', 'JobController@store')->middleware('auth:api');
Route::put('jobs/{id}', 'JobController@update')->middleware('auth:api');
Route::delete('jobs/{id}', 'JobController@delete')->middleware('auth:api');




Route::get('stafflist', 'StaffController@stafflist')->middleware('auth:api'); // show staff list 
Route::post('contact-us', 'Api\CommonController@contactus');  /// contact us api