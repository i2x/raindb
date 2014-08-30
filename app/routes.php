<?php








/** ------------------------------------------
 *  Route constraint patterns
 *  ------------------------------------------
 */
Route::pattern('id', '[0-9]+');







# Static Pages. Redirecting admin so admin cannot access these pages.
Route::group(['before' => 'redirectAdmin'], function()
{
	Route::get('/', ['as' => 'home', 'uses' => 'PagesController@getHome']);
	Route::get('/about', ['as' => 'about', 'uses' => 'PagesController@getAbout']);
	Route::get('/contact', ['as' => 'contact', 'uses' => 'PagesController@getContact']);
});

# Registration
Route::group(['before' => 'guest'], function()
{
	Route::get('/register', 'RegistrationController@create');
	Route::post('/register', ['as' => 'registration.store', 'uses' => 'RegistrationController@store']);
});

# Authentication
Route::get('login', ['as' => 'login', 'uses' => 'SessionsController@create'])->before('guest');
Route::get('logout', ['as' => 'logout', 'uses' => 'SessionsController@destroy']);
Route::resource('sessions', 'SessionsController' , ['only' => ['create','store','destroy']]);

# Forgotten Password
Route::group(['before' => 'guest'], function()
{
	Route::get('forgot_password', 'RemindersController@getRemind');
	Route::post('forgot_password','RemindersController@postRemind');
	Route::get('reset_password/{token}', 'RemindersController@getReset');
	Route::post('reset_password/{token}', 'RemindersController@postReset');
});

Route::group(['before' => 'auth|(standardUser || admin)'], function()
# Standard User Routes
{
	// Profile 
	
	//Route::get('userProtected', 'StandardUserController@getUserProtected');
	//Route::resource('profiles', 'UsersController', ['only' => ['show', 'edit', 'update']]);
	
	
	
	//Data
	
	Route::get('historical', 'HistoricalController@getIndex');
	Route::post('historical', 'HistoricalController@postIndex');
	Route::get('historical/data', 'HistoricalController@getData');
	
	

	//Graph 
	Route::get('graph', 'GraphController@getIndex');
	Route::post('graph', 'GraphController@getIndex');

	//Select DropDown
	Route::post('province',  'SelectController@province');
	Route::post('ampher',  'SelectController@ampher');
	Route::post('station', 'SelectController@station');
	Route::post('season',  'SelectController@season');
        Route::post('basemonth',  'SelectController@basemonth');
	
	
	
	//Import
	Route::get('import', 'ImportController@getImport');
	Route::post('import', 'ImportController@postImport');
	Route::get('import/data', 'ImportController@getData');
	Route::post('import/upload', 'ImportController@toDatabase');
	
	//Log
	
	Route::get('log','LogController@getLog');
	Route::get('log/data','LogController@getData');
	
	
	//Report
	Route::get('report','ReportController@getIndex');
	Route::post('report','ReportController@postIndex');
	
	
	//Forecast
	
	Route::get('forecast','ForecastController@getIndex');
	Route::post('forecast','ForecastController@postIndex');
	
	

	
	
	





});

# Admin Routes
Route::group(['before' => 'auth|admin'], function()
{
	Route::get('/admin', ['as' => 'admin_dashboard', 'uses' => 'AdminController@getHome']);
    Route::resource('admin/profiles', 'AdminUsersController', ['only' => ['index', 'show', 'edit', 'update', 'destroy']]);
    
    
    
    //index
    Route::get('database', 'CRUDController@getIndex');
    
    
    //Amphur CRUD
    Route::get('database/amphur', 'xAmphurController@index');
    Route::get('database/amphur/data', 'xAmphurController@getData');
    
    Route::get('database/amphur/{id}/update', 'xAmphurController@getUpdate');
    Route::post('database/amphur/{id}/update', 'xAmphurController@postUpdate');
        
    Route::get('database/amphur/create', 'xAmphurController@getCreate');
    Route::post('database/amphur/create', 'xAmphurController@postCreate');
    
    
    Route::post('database/amphur/{id}/delete', 'xAmphurController@postDelete');
    
    
    //
    
    Route::get('refrefresh', 'RefRefreshController@getIndex');
    Route::post('refrefresh', 'RefRefreshController@postIndex');
    
    
    
    
    
        
    
    
    
    
    
    
    
    



    
    
    
    
    
    


});



