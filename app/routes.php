<?php

/**************** static methods ******************/
Route::get('/', 'HomeController@home');
/**************** static methods ******************/


/**************** user methods ******************/

Route::get('/user-section', 'UserController@userSection');
Route::get('/find-group-member-by-email', 'UserController@findGroupMemberByEmail');
Route::get('/count-member-requests', 'UserController@memberRequestCount');
Route::get('/new-member-requests', 'UserController@newMemberRequests');
Route::get('/data-new-member-requests', 'UserController@dataNewMemberRequests');

/**************** user methods ******************/

/**************** authentication methods ******************/

Route::post('/is-valid-admin', 'AuthenticationController@isValidAdmin');

Route::get('/register', 'AuthenticationController@register');
Route::post('/save-user', 'AuthenticationController@saveUser');
Route::get('/registered', 'AuthenticationController@registered');

Route::get('/login', 'AuthenticationController@login');
Route::post('/is-valid-user', 'AuthenticationController@isValidUser');
Route::get('/is-duplicate-user', 'AuthenticationController@remove');

Route::get('/password-recovery', 'AuthenticationController@passwordRecovery');
Route::get('/password-sent', 'AuthenticationController@passwordSent');

Route::get('/activate-account/{code}', 'AuthenticationController@activateAccount');
Route::get('/account-activated', 'AuthenticationController@accountActivated');

Route::get('/logout', 'AuthenticationController@logout');

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
Route::get('/save-group-member', 'GroupController@saveGroupMember');
Route::get('/remove-group-member/{id}', 'GroupController@removeGroupMember');
Route::post('/remove-group-members', 'GroupController@removeGroupMembers');
Route::get('/all-group-members', 'GroupController@allGroupMembers');

Route::get('/data-all-groups', 'GroupController@dataAllGroups');
Route::get('/data-all-group-members', 'GroupController@dataAllGroupMembers');

/**************** group methods ******************/

