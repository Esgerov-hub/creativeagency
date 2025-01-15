<?php
use Illuminate\Support\Facades\Route;

Route::get('/admin/login', 'AuthController@login')->name('login');
Route::post('/admin/loginAccept', 'AuthController@loginAccept')->name('loginAccept');
Route::group([
    'prefix' => implode('/', [LaravelLocalization::setLocale(), 'admin']),
    'middleware' => ['admin', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]],
    function()  {
    Route::get('/logout', 'AuthController@logout')->name('logout');
    Route::get('/home', 'HomeController@index')->name('index');
    Route::post('/uploads', 'HomeController@uploads')->name('uploads');
    Route::resource('roles','RoleController');
    Route::resource('permissions','PermissionController');
    Route::resource('cms-users', 'CmsUserController');
    Route::get('/logs', 'CmsUserController@logs')->name('cms-users.logs');
    Route::resource('translations', 'TranslationsController');
    Route::get('/admin-words', 'TranslationsController@admin_word_index')->name('admin-words.index');
    Route::get('/admin-words/{code}', 'TranslationsController@admin_word_edit')->name('admin-words.edit');
    Route::put('/admin-words/update/{code}', 'TranslationsController@admin_word_update')->name('admin-words.update');
    Route::get('/site-words', 'TranslationsController@site_word_index')->name('site-words.index');
    Route::get('/site-words/{code}', 'TranslationsController@site_word_edit')->name('site-words.edit');
    Route::put('/site-words/update/{code}', 'TranslationsController@site_word_update')->name('site-words.update');
    Route::resource('settings', 'SettingsController');
    Route::resource('sliders', 'SlidersController');
    Route::resource('category', 'CategoryController');
    Route::resource('news', 'NewsController');
    Route::resource('enlightenment', 'EnlightenmentController');
    Route::resource('service', 'ServiceController');
    Route::post('/services/order-by', 'ServiceController@orderBy')->name('services.orderBy');
    Route::resource('useful-link', 'UsefulLinkController');
    Route::get('useful-categories/parent', 'UsefulCategoryController@getParentCategories')->name('useful-categories.getParentCategories');
    Route::get('useful-categories/sub-parent', 'UsefulCategoryController@getSubCategories')->name('useful-categories.getSubParentCategories');
    Route::resource('useful-categories', 'UsefulCategoryController');
    Route::resource('useful', 'UsefulController');
    Route::resource('institute-categories', 'InstituteCategoryController');
    Route::resource('healthy-eating', 'HealthyEatingController');
    Route::resource('city', 'CityController');
    Route::resource('laboratory-category', 'LaboratoryCategoryController');
    Route::resource('laboratory', 'LaboratoryController');
    Route::resource('virtual-laboratory', 'VirtualLaboratoryController');
    Route::get('career/contact', 'CareerController@contact')->name('career.contact');
    Route::get('career/volunteer', 'CareerController@volunteer')->name('career.volunteer');
    Route::delete('career/contact-destroy/{id}', 'CareerController@contactDestroy')->name('career.contactDestroy');
    Route::resource('career', 'CareerController');
    Route::resource('positions', 'PositionController');
    Route::get('parent-positions/{id}', 'PositionController@parent')->name('positions.parent');
    Route::get('institute/{slug}', 'InstituteController@index')->name('institute.index');
    Route::get('institute/create/{slug}', 'InstituteController@create')->name('institute.create');
    Route::post('institute', 'InstituteController@store')->name('institute.store');
    Route::get('institute/{id}/{slug}', 'InstituteController@edit')->name('institute.edit');
    Route::put('institute/{id}', 'InstituteController@update')->name('institute.update');
    Route::delete('institute/{id}', 'InstituteController@destroy')->name('institute.destroy');
    Route::resource('complaint', 'ComplaintController');
    Route::resource('tariff-category', 'TariffCategoryController');
    Route::get('tariff/parent', 'TariffController@getParentTariff')->name('tariff.getParentTariff');
    Route::get('tariff/sub-parent', 'TariffController@getSubTariff')->name('tariff.getSubParentTariff');
    Route::resource('tariff', 'TariffController');
});
