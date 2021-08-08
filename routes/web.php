<?php

Route::bind('post_slug', function ($value) {
    return \App\Models\Post::whereSlug($value)->firstOrFail();
});
Route::bind('category_slug', function ($value) {
    return \App\Models\Category::whereSlug($value)->firstOrFail();
});

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

/*Route::get('/', function () {
   // return view('angle');
    return view('frontend.home');
});*/

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@newHome']);
Route::get('/register', ['as' => 'register', 'uses' => 'HomeController@register']);
Route::post('/register', ['as' => 'register', 'uses' => 'HomeController@storeRegistration']);


Route::get('/old-home', ['as' => 'home-old', 'uses' => 'HomeController@index']);
Route::get('contact-us', ['as' => 'contact', 'uses' => 'HomeController@showContactUs']);
Route::post('/contact-us/submit','ContactusQueriesController@submitQuery')
    ->name('contactus_queries.contactus_query.query');

// Route::get('post/{post_id}', ['as' => 'post.details', 'uses' => 'HomeController@showPost']);
Route::get('category/{category_slug}', ['as' => 'category.posts.slug', 'uses' => 'HomeController@showSlugCategoryPosts']);


//Route::get('test', 'TestController@show')->name('test');
//Route::get('preview-mail', 'TestController@previewMail')->name('previewmail');





Route::group([ 'prefix' => 'admin',], function () {
    Route::get('/', 'Admin\AdminController@showLogin')->name('admin.login');
    Route::get('login', 'Admin\AdminController@showLogin')->name('admin.login');
    Route::post('login', 'Admin\AdminController@login')->name('admin.login');
    Route::get('logout', 'Admin\AdminController@logout')->name('admin.logout');
});
Route::group([ 'prefix' => 'admin', 'middleware' => ['admin']], function () {
    Route::get('unit-test', 'TestController@index')->name('unit-test');
    Route::get('dashboard', 'Admin\AdminController@showDashboard')->name('admin.dashboard');
    Route::get('reset-password', 'Admin\AdminController@showResetPassword')->name('admin.resetpassword');
    Route::put('reset-password', 'Admin\AdminController@resetPassword')->name('admin.password.update');


    Route::group(
        [
            'prefix' => 'posts',
        ], function () {

        Route::get('/', 'PostsController@index')
            ->name('posts.post.index');

        Route::get('/create','PostsController@create')
            ->name('posts.post.create');

        Route::get('/show/{post}','PostsController@show')
            ->name('posts.post.show')
            ->where('id', '[0-9]+');

        Route::get('/{post}/edit','PostsController@edit')
            ->name('posts.post.edit')
            ->where('id', '[0-9]+');

        Route::post('/', 'PostsController@store')
            ->name('posts.post.store');

        Route::put('post/{post}', 'PostsController@update')
            ->name('posts.post.update')
            ->where('id', '[0-9]+');

        Route::delete('/post/{post}','PostsController@destroy')
            ->name('posts.post.destroy')
            ->where('id', '[0-9]+');

    });

    Route::group(
        [
            'prefix' => 'categories',
        ], function () {

        Route::get('/', 'CategoriesController@index')
            ->name('categories.category.index');

        Route::get('/create','CategoriesController@create')
            ->name('categories.category.create');

        Route::get('/show/{category}','CategoriesController@show')
            ->name('categories.category.show')
            ->where('id', '[0-9]+');

        Route::get('/{category}/edit','CategoriesController@edit')
            ->name('categories.category.edit')
            ->where('id', '[0-9]+');

        Route::post('/', 'CategoriesController@store')
            ->name('categories.category.store');

        Route::put('category/{category}', 'CategoriesController@update')
            ->name('categories.category.update')
            ->where('id', '[0-9]+');

        Route::delete('/category/{category}','CategoriesController@destroy')
            ->name('categories.category.destroy')
            ->where('id', '[0-9]+');

    });

    Route::group(
        [
            'prefix' => 'contactus_queries',
        ], function () {

        Route::get('/', 'ContactusQueriesController@index')
            ->name('contactus_queries.contactus_query.index');

        Route::get('/create','ContactusQueriesController@create')
            ->name('contactus_queries.contactus_query.create');

        Route::get('/show/{contactusQuery}','ContactusQueriesController@show')
            ->name('contactus_queries.contactus_query.show')
            ->where('id', '[0-9]+');

        Route::get('/{contactusQuery}/edit','ContactusQueriesController@edit')
            ->name('contactus_queries.contactus_query.edit')
            ->where('id', '[0-9]+');

        Route::post('/', 'ContactusQueriesController@store')
            ->name('contactus_queries.contactus_query.store');

        Route::put('contactus_query/{contactusQuery}', 'ContactusQueriesController@update')
            ->name('contactus_queries.contactus_query.update')
            ->where('id', '[0-9]+');

        Route::delete('/contactus_query/{contactusQuery}','ContactusQueriesController@destroy')
            ->name('contactus_queries.contactus_query.destroy')
            ->where('id', '[0-9]+');

    });

    Route::group(
        [
            'prefix' => 'roles',
        ], function () {

        Route::get('/', 'RolesController@index')
            ->name('roles.roles.index');

        Route::get('/create','RolesController@create')
            ->name('roles.roles.create');

        Route::get('/show/{roles}','RolesController@show')
            ->name('roles.roles.show')
            ->where('id', '[0-9]+');

        Route::get('/{roles}/edit','RolesController@edit')
            ->name('roles.roles.edit')
            ->where('id', '[0-9]+');

        Route::post('/', 'RolesController@store')
            ->name('roles.roles.store');

        Route::put('roles/{roles}', 'RolesController@update')
            ->name('roles.roles.update')
            ->where('id', '[0-9]+');

        Route::delete('/roles/{roles}','RolesController@destroy')
            ->name('roles.roles.destroy')
            ->where('id', '[0-9]+');

    });



    Route::group(
        [
            'prefix' => 'faqs',
        ], function () {

        Route::get('/', 'FaqsController@index')
            ->name('faqs.faq.index');

        Route::get('/create','FaqsController@create')
            ->name('faqs.faq.create');

        Route::get('/show/{faq}','FaqsController@show')
            ->name('faqs.faq.show')
            ->where('id', '[0-9]+');

        Route::get('/{faq}/edit','FaqsController@edit')
            ->name('faqs.faq.edit')
            ->where('id', '[0-9]+');

        Route::post('/', 'FaqsController@store')
            ->name('faqs.faq.store');

        Route::put('faq/{faq}', 'FaqsController@update')
            ->name('faqs.faq.update')
            ->where('id', '[0-9]+');

        Route::get('faq_ajax_update/{faq}', 'FaqsController@updateAjax')
            ->name('faqs.faq.update.ajax')
            ->where('id', '[0-9]+');


        Route::delete('/faq/{faq}','FaqsController@destroy')
            ->name('faqs.faq.destroy')
            ->where('id', '[0-9]+');

    });


    Route::group(
        [
            'prefix' => 'policies',
        ], function () {

        Route::get('terms/client', 'SysSettingsController@showClientTerms')->name('sys_settings.terms.client');
        Route::get('terms/staff', 'SysSettingsController@showStaffTerms')->name('sys_settings.terms.staff');
        Route::get('privacy', 'SysSettingsController@showPrivacy')->name('sys_settings.privacy');
        Route::put('update', 'SysSettingsController@updatePolicy')->name('sys_settings.policy.update');
    });

    Route::group(['prefix' => 'settings/{type}',], function () {

        Route::get('/','SettingsController@show')->name('settings.object.index');
        Route::get('/create','SettingsController@create')->name('settings.object.create');
        Route::get('/edit','SettingsController@edit')->name('settings.object.edit');
        Route::post('/', 'SettingsController@store')->name('settings.object.store');
        Route::delete('/delete','SettingsController@destroy')->name('settings.object.destroy');
    });

    Route::group(
        [
            'prefix' => 'sys_settings',
        ], function () {

        Route::get('/', 'SysSettingsController@index')
            ->name('sys_settings.sys_setting.index');

        Route::get('/create','SysSettingsController@create')
            ->name('sys_settings.sys_setting.create');

        Route::get('/show/{sysSetting}','SysSettingsController@show')
            ->name('sys_settings.sys_setting.show')
            ->where('id', '[0-9]+');

        Route::get('/{sysSetting}/edit','SysSettingsController@edit')
            ->name('sys_settings.sys_setting.edit')
            ->where('id', '[0-9]+');

        Route::post('/', 'SysSettingsController@store')
            ->name('sys_settings.sys_setting.store');

        Route::put('sys_setting/{sysSetting}', 'SysSettingsController@update')
            ->name('sys_settings.sys_setting.update')
            ->where('id', '[0-9]+');

        Route::delete('/sys_setting/{sysSetting}','SysSettingsController@destroy')
            ->name('sys_settings.sys_setting.destroy')
            ->where('id', '[0-9]+');

    });


    Route::group(
        [
            'prefix' => 'skills',
        ], function () {

        Route::get('/', 'SkillsController@index')
            ->name('skills.skill.index');

        Route::get('/create','SkillsController@create')
            ->name('skills.skill.create');

        Route::get('/show/{skill}','SkillsController@show')
            ->name('skills.skill.show')
            ->where('id', '[0-9]+');

        Route::get('/{skill}/edit','SkillsController@edit')
            ->name('skills.skill.edit')
            ->where('id', '[0-9]+');

        Route::post('/', 'SkillsController@store')
            ->name('skills.skill.store');

        Route::put('skill/{skill}', 'SkillsController@update')
            ->name('skills.skill.update')
            ->where('id', '[0-9]+');

        Route::delete('/skill/{skill}','SkillsController@destroy')
            ->name('skills.skill.destroy')
            ->where('id', '[0-9]+');

    });
	
	   Route::group([ 'prefix' => 'job', ], function () {
        Route::get('/createjob', 'JobController@createjob');
		Route::post('/getjobdetails', 'JobController@getjobdetails');
		Route::post('/jobapplicant', 'JobController@jobapplicant');//working
		Route::get('/edit/{job}','JobController@editjob')->where('id', '[0-9]+');//edit job
        Route::put('/updatejob/{job}','JobController@updatejob')->where('id', '[0-9]+');//working
		Route::delete('/delete/{job}','JobController@deletejob')->where('id', '[0-9]+');//working
		
    });



    Route::group(
        [
            'prefix' => 'videos',
        ], function () {

        Route::get('/', 'VideosController@index')
            ->name('videos.videos.index');

        Route::get('/create','VideosController@create')
            ->name('videos.videos.create');

        Route::get('/show/{videos}','VideosController@show')
            ->name('videos.videos.show')
            ->where('id', '[0-9]+');

        Route::get('/{videos}/edit','VideosController@edit')
            ->name('videos.videos.edit')
            ->where('id', '[0-9]+');

        Route::post('/', 'VideosController@store')
            ->name('videos.videos.store');

        Route::put('videos/{videos}', 'VideosController@update')
            ->name('videos.videos.update')
            ->where('id', '[0-9]+');

        Route::delete('/videos/{videos}','VideosController@destroy')
            ->name('videos.videos.destroy')
            ->where('id', '[0-9]+');

    });

});

Route::get('{post_slug}', ['as' => 'post.details.slug', 'uses' => 'HomeController@showSluggifiedPost']);













