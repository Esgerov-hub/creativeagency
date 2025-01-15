<?php

use Illuminate\Support\Facades\Route;

Route::group([
'prefix' => implode('/', [LaravelLocalization::setLocale(), '']),
'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]],
function() {
    Route::get('/search', 'HomeController@search')->name('search');
    Route::get('/404', 'HomeController@notPage')->name('404');
    Route::get('/', 'HomeController@index')->name('index');
    Route::get('/about', 'HomeController@about')->name('about');
    Route::get('/team', 'HomeController@team')->name('team');
    Route::get('/portfolio', 'HomeController@portfolio')->name('portfolio');
    Route::get('/portfolio/{slug}', 'HomeController@portfolioDetail')->name('portfolioDetail');
    Route::get('/service/{slug}', 'HomeController@service')->name('service');
    Route::get('/news', 'HomeController@news')->name('news');
    Route::get('/news/{slug}', 'HomeController@newsDetails')->name('newsDetail');
    Route::get('/contact', 'HomeController@contact')->name('contact');
    Route::post('/send-contact', 'AjaxController@sendContact')->name('sendContact');
});
Route::fallback(function () {
    abort(404);
});
