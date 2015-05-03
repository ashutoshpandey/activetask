<?php

/**************** user methods ******************/

Route::get('/user-section', 'UserController@userSection');

/**************** user methods ******************/

/**************** authentication methods ******************/

Route::get('/login', 'AuthenticationController@create');
Route::get('/register', 'AuthenticationController@register');
Route::post('/save-user', 'AuthenticationController@saveUser');
Route::get('/registered', 'AuthenticationController@registered');
Route::get('/is-valid-user', 'AuthenticationController@update');
Route::get('/is-duplicate-user', 'AuthenticationController@remove');
Route::get('/password-recovery', 'AuthenticationController@passwordRecovery');
Route::get('/password-sent', 'AuthenticationController@passwordSent');
Route::get('/is-valid-admin', 'AuthenticationController@isValidAdmin');
Route::get('/activate-account/{code}', 'AuthenticationController@activateAccount');
Route::get('/account-activated', 'AuthenticationController@accountActivated');

/**************** authentication methods ******************/

/**************** task methods ******************/

Route::get('/create-task', 'TaskController@create');
Route::get('/find-task/{id}', 'TaskController@find');
Route::get('/update-task', 'TaskController@update');
Route::get('/remove-task/{id}', 'TaskController@remove');
Route::get('/all-tasks', 'TaskController@all');

Route::get('/data-all-tasks', 'TaskController@allTasks');
Route::get('/data-all-task-items/{id}', 'TaskController@allTaskItems');

/**************** task methods ******************/
