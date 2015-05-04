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
Route::post('/save-task', 'TaskController@save');
Route::get('/find-task/{id}', 'TaskController@find');
Route::get('/update-task', 'TaskController@update');
Route::get('/remove-task/{id}', 'TaskController@remove');
Route::get('/all-tasks', 'TaskController@all');

Route::get('/task-items/{id}', 'TaskController@taskItems');
Route::post('/save-task-item', 'TaskController@saveTaskItem');
Route::get('/remove-task-item/{id}', 'TaskController@removeGroupMember');
Route::post('/remove-task-items', 'TaskController@removeGroupMembers');

Route::get('/data-all-tasks', 'TaskController@allTasks');
Route::get('/data-all-task-items', 'TaskController@allTaskItems');

/**************** task methods ******************/

/**************** group methods ******************/

Route::get('/create-group', 'GroupController@create');
Route::post('/save-group', 'GroupController@save');
Route::get('/find-group/{id}', 'GroupController@find');
Route::get('/update-group', 'GroupController@update');
Route::get('/remove-group/{id}', 'GroupController@remove');
Route::post('/remove-groups', 'GroupController@removeGroups');
Route::get('/all-groups', 'GroupController@all');

Route::get('/group-members/{id}', 'GroupController@groupMembers');
Route::post('/save-group-member', 'GroupController@saveGroupMember');
Route::get('/remove-group-member/{id}', 'GroupController@removeGroupMember');
Route::post('/remove-group-members', 'GroupController@removeGroupMembers');
Route::get('/all-group-members', 'GroupController@allGroupMembers');

Route::get('/data-all-groups', 'GroupController@allGroups');
Route::get('/data-all-group-members', 'GroupController@allGroupMembers');

/**************** task methods ******************/
