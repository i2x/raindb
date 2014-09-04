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
	
	
	
	//Data
	
	Route::get('historical', 'HistoricalController@getIndex');
	Route::post('historical', 'HistoricalController@postIndex');
	Route::get('historical/data', 'HistoricalController@getData');
	
	
	
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
	
	

	//Graph
	Route::get('graph', 'GraphController@getIndex');
	Route::post('graph', 'GraphController@postIndex');
	
	//Select DropDown
	Route::post('province',  'SelectController@province');
	Route::post('ampher',  'SelectController@ampher');
	Route::post('station', 'SelectController@station');
	Route::post('season',  'SelectController@season');
	Route::post('basemonth',  'SelectController@basemonth');
	
	
	
	
	//Report
	Route::get('report','ReportController@getIndex');
	Route::post('report','ReportController@postIndex');
	
	//
	
	Route::get('schedule','ScheduleController@getIndex');
	Route::post('schedule','ScheduleController@postIndex');
	
	
	
	
});

Route::group(['before' => 'auth|(standardUser || admin)'], function()
# Standard User Routes
{
	// Profile 
	
	//Route::get('userProtected', 'StandardUserController@getUserProtected');
	//Route::resource('profiles', 'UsersController', ['only' => ['show', 'edit', 'update']]);
	
	
	

	
	

	
	
	
	//Import
	Route::get('import', 'ImportController@getImport');
	Route::post('import', 'ImportController@postImport');
	Route::get('import/data', 'ImportController@getData');
	Route::get('import/missing', 'ImportController@getMissing');
	
	Route::post('import/upload', 'ImportController@toDatabase');
	
	
	
	
	//Log
	
	Route::get('log','LogController@getLog');
	Route::get('log/data','LogController@getData');
	
	

	
	
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
    
    
    //Groups CRUD
    Route::get('database/groups', 'xGroupsController@index');
    Route::get('database/groups/data', 'xGroupsController@getData');
    
    Route::get('database/groups/{id}/update', 'xGroupsController@getUpdate');
    Route::post('database/groups/{id}/update', 'xGroupsController@postUpdate');
    
    Route::get('database/groups/create', 'xGroupsController@getCreate');
    Route::post('database/groups/create', 'xGroupsController@postCreate');
    
    
    Route::post('database/groups/{id}/delete', 'xGroupsController@postDelete');
    
    
    
    
    
    
    
    //Password_reminders CRUD
    Route::get('database/password_reminders', 'xPasswordRemindersController@index');
    Route::get('database/password_reminders/data', 'xPasswordRemindersController@getData');
    
    Route::get('database/password_reminders/{id}/update', 'xPasswordRemindersController@getUpdate');
    Route::post('database/password_reminders/{id}/update', 'xPasswordRemindersController@postUpdate');
    
    Route::get('database/password_reminders/create', 'xPasswordRemindersController@getCreate');
    Route::post('database/password_reminders/create', 'xPasswordRemindersController@postCreate');
    
    
    Route::post('database/password_reminders/{id}/delete', 'xPasswordRemindersController@postDelete');
    
    
    
    //Permission_role CRUD
    Route::get('database/permission_role', 'xPermissionRoleController@index');
    Route::get('database/permission_role/data', 'xPermissionRoleController@getData');
    
    Route::get('database/permission_role/{id}/update', 'xPermissionRoleController@getUpdate');
    Route::post('database/permission_role/{id}/update', 'xPermissionRoleController@postUpdate');
    
    Route::get('database/permission_role/create', 'xPermissionRoleController@getCreate');
    Route::post('database/permission_role/create', 'xPermissionRoleController@postCreate');
    
    
    Route::post('database/permission_role/{id}/delete', 'xPermissionRoleController@postDelete');
    
    
    //Permissions CRUD
    Route::get('database/permissions', 'xPermissionsController@index');
    Route::get('database/permissions/data', 'xPermissionsController@getData');
    
    Route::get('database/permissions/{id}/update', 'xPermissionsController@getUpdate');
    Route::post('database/permissions/{id}/update', 'xPermissionsController@postUpdate');
    
    Route::get('database/permissions/create', 'xPermissionsController@getCreate');
    Route::post('database/permissions/create', 'xPermissionsController@postCreate');
    
    
    Route::post('database/permissions/{id}/delete', 'xPermissionsController@postDelete');
    
    
    
    //Riverbasin CRUD
    Route::get('database/riverbasin', 'xRiverbasinController@index');
    Route::get('database/riverbasin/data', 'xRiverbasinController@getData');
    
    Route::get('database/riverbasin/{id}/update', 'xRiverbasinController@getUpdate');
    Route::post('database/riverbasin/{id}/update', 'xRiverbasinController@postUpdate');
    
    Route::get('database/riverbasin/create', 'xRiverbasinController@getCreate');
    Route::post('database/riverbasin/create', 'xRiverbasinController@postCreate');
    
    
    Route::post('database/riverbasin/{id}/delete', 'xRiverbasinController@postDelete');
    
    
    
    //Roles CRUD
    Route::get('database/roles', 'xRolesController@index');
    Route::get('database/roles/data', 'xRolesController@getData');
    
    Route::get('database/roles/{id}/update', 'xRolesController@getUpdate');
    Route::post('database/roles/{id}/update', 'xRolesController@postUpdate');
    
    Route::get('database/roles/create', 'xRolesController@getCreate');
    Route::post('database/roles/create', 'xRolesController@postCreate');
    
    
    Route::post('database/roles/{id}/delete', 'xRolesController@postDelete');
    
    
    
    //Tbl_ampher CRUD
    Route::get('database/tbl_ampher', 'xTblAmpherController@index');
    Route::get('database/tbl_ampher/data', 'xTblAmpherController@getData');
    
    Route::get('database/tbl_ampher/{id}/update', 'xTblAmpherController@getUpdate');
    Route::post('database/tbl_ampher/{id}/update', 'xTblAmpherController@postUpdate');
    
    Route::get('database/tbl_ampher/create', 'xTblAmpherController@getCreate');
    Route::post('database/tbl_ampher/create', 'xTblAmpherController@postCreate');
    
    
    Route::post('database/tbl_ampher/{id}/delete', 'xTblAmpherController@postDelete');
    
    
    
    //tbl_import_log CRUD
    Route::get('database/tbl_import_log', 'xTblImportLogController@index');
    Route::get('database/tbl_import_log/data', 'xTblImportLogController@getData');
    
    Route::get('database/tbl_import_log/{id}/update', 'xTblImportLogController@getUpdate');
    Route::post('database/tbl_import_log/{id}/update', 'xTblImportLogController@postUpdate');
    
    Route::get('database/tbl_import_log/create', 'xTblImportLogController@getCreate');
    Route::post('database/tbl_import_log/create', 'xTblImportLogController@postCreate');
    
    
    Route::post('database/tbl_import_log/{id}/delete', 'xTblImportLogController@postDelete');
    
    
    //tbl_province CRUD
    Route::get('database/tbl_province', 'xTblProvinceController@index');
    Route::get('database/tbl_province/data', 'xTblProvinceController@getData');
    
    Route::get('database/tbl_province/{id}/update', 'xTblProvinceController@getUpdate');
    Route::post('database/tbl_province/{id}/update', 'xTblProvinceController@postUpdate');
    
    Route::get('database/tbl_province/create', 'xTblProvinceController@getCreate');
    Route::post('database/tbl_province/create', 'xTblProvinceController@postCreate');
    
    
    Route::post('database/tbl_province/{id}/delete', 'xTblProvinceController@postDelete');
    
    
    //tbl_rain_measurement CRUD
    Route::get('database/tbl_rain_measurement', 'xTblRainMeasurementController@index');
    Route::get('database/tbl_rain_measurement/data', 'xTblRainMeasurementController@getData');
    
    Route::get('database/tbl_rain_measurement/{id}/update', 'xTblRainMeasurementController@getUpdate');
    Route::post('database/tbl_rain_measurement/{id}/update', 'xTblRainMeasurementController@postUpdate');
    
    Route::get('database/tbl_rain_measurement/create', 'xTblRainMeasurementController@getCreate');
    Route::post('database/tbl_rain_measurement/create', 'xTblRainMeasurementController@postCreate');
    
    
    Route::post('database/tbl_rain_measurement/{id}/delete', 'xTblRainMeasurementController@postDelete');
    
    
    //tbl_rain_station CRUD
    Route::get('database/tbl_rain_station', 'xTblRainStationController@index');
    Route::get('database/tbl_rain_station/data', 'xTblRainStationController@getData');
    
    Route::get('database/tbl_rain_station/{id}/update', 'xTblRainStationController@getUpdate');
    Route::post('database/tbl_rain_station/{id}/update', 'xTblRainStationController@postUpdate');
    
    Route::get('database/tbl_rain_station/create', 'xTblRainStationController@getCreate');
    Route::post('database/tbl_rain_station/create', 'xTblRainStationController@postCreate');
    
    
    Route::post('database/tbl_rain_station/{id}/delete', 'xTblRainStationController@postDelete');
    
    
    
    //tbl_ref_data CRUD
    Route::get('database/tbl_ref_data', 'xTblRefDataController@index');
    Route::get('database/tbl_ref_data/data', 'xTblRefDataController@getData');
    
    Route::get('database/tbl_ref_data/{id}/update', 'xTblRefDataController@getUpdate');
    Route::post('database/tbl_ref_data/{id}/update', 'xTblRefDataController@postUpdate');
    
    Route::get('database/tbl_ref_data/create', 'xTblRefDataController@getCreate');
    Route::post('database/tbl_ref_data/create', 'xTblRefDataController@postCreate');
    
    
    Route::post('database/tbl_ref_data/{id}/delete', 'xTblRefDataController@postDelete');
    
    
    
    //tbl_ref_data4forecast_ping CRUD
    Route::get('database/tbl_ref_data4forecast_ping', 'xTblRefData4forecastPingController@index');
    Route::get('database/tbl_ref_data4forecast_ping/data', 'xTblRefData4forecastPingController@getData');
    
    Route::get('database/tbl_ref_data4forecast_ping/{id}/update', 'xTblRefData4forecastPingController@getUpdate');
    Route::post('database/tbl_ref_data4forecast_ping/{id}/update', 'xTblRefData4forecastPingController@postUpdate');
    
    Route::get('database/tbl_ref_data4forecast_ping/create', 'xTblRefData4forecastPingController@getCreate');
    Route::post('database/tbl_ref_data4forecast_ping/create', 'xTblRefData4forecastPingController@postCreate');
    
    
    Route::post('database/tbl_ref_data4forecast_ping/{id}/delete', 'xTblRefData4forecastPingController@postDelete');
    
    
    
    
    //tbl_ref_settings CRUD
    Route::get('database/tbl_ref_settings', 'xTblRefSettingsController@index');
    Route::get('database/tbl_ref_settings/data', 'xTblRefSettingsController@getData');
    
    Route::get('database/tbl_ref_settings/{id}/update', 'xTblRefSettingsController@getUpdate');
    Route::post('database/tbl_ref_settings/{id}/update', 'xTblRefSettingsController@postUpdate');
    
    Route::get('database/tbl_ref_settings/create', 'xTblRefSettingsController@getCreate');
    Route::post('database/tbl_ref_settings/create', 'xTblRefSettingsController@postCreate');
    
    
    Route::post('database/tbl_ref_settings/{id}/delete', 'xTblRefSettingsController@postDelete');
    
    
    //tbl_season CRUD
    Route::get('database/tbl_season', 'xTblSeasonController@index');
    Route::get('database/tbl_season/data', 'xTblSeasonController@getData');
    
    Route::get('database/tbl_season/{id}/update', 'xTblSeasonController@getUpdate');
    Route::post('database/tbl_season/{id}/update', 'xTblSeasonController@postUpdate');
    
    Route::get('database/tbl_season/create', 'xTblSeasonController@getCreate');
    Route::post('database/tbl_season/create', 'xTblSeasonController@postCreate');
    
    
    Route::post('database/tbl_season/{id}/delete', 'xTblSeasonController@postDelete');
    
    
    //tbl_selected_stations CRUD
    Route::get('database/tbl_selected_stations', 'xTblSelectedStationsController@index');
    Route::get('database/tbl_selected_stations/data', 'xTblSelectedStationsController@getData');
    
    Route::get('database/tbl_selected_stations/{id}/update', 'xTblSelectedStationsController@getUpdate');
    Route::post('database/tbl_selected_stations/{id}/update', 'xTblSelectedStationsController@postUpdate');
    
    Route::get('database/tbl_selected_stations/create', 'xTblSelectedStationsController@getCreate');
    Route::post('database/tbl_selected_stations/create', 'xTblSelectedStationsController@postCreate');
    
    
    Route::post('database/tbl_selected_stations/{id}/delete', 'xTblSelectedStationsController@postDelete');
    
    
    //tbl_source CRUD
    Route::get('database/tbl_source', 'xTblSourceController@index');
    Route::get('database/tbl_source/data', 'xTblSourceController@getData');
    
    Route::get('database/tbl_source/{id}/update', 'xTblSourceController@getUpdate');
    Route::post('database/tbl_source/{id}/update', 'xTblSourceController@postUpdate');
    
    Route::get('database/tbl_source/create', 'xTblSourceController@getCreate');
    Route::post('database/tbl_source/create', 'xTblSourceController@postCreate');
    
    
    Route::post('database/tbl_source/{id}/delete', 'xTblSourceController@postDelete');
    
    
    
        
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    Route::get('refrefresh', 'RefRefreshController@getIndex');
    Route::post('refrefresh', 'RefRefreshController@postIndex');
    
    
    
    
    
        
    
    
    
    
    
    
    
    



    
    
    
    
    
    


});



