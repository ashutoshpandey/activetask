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

/**************** group methods ******************/


/********************** json methods for apps ********************/

Route::get('/data-all-tasks/{id}', 'TaskController@dataAllTasks');
Route::get('/data-all-assigned-tasks/{id}', 'TaskController@dataAllAssignedTasks');
Route::get('/data-all-task-items/{taskId}', 'TaskController@dataAllTaskItems');
Route::post('/data-all-assigned-task-items', 'TaskController@dataAllAssignedTaskItems');
Route::get('/data-pending-tasks-count/{taskId}', 'TaskController@dataPendingTasksCount');
Route::post('/data-save-task', 'TaskController@dataSaveTask');
Route::post('/data-save-task-item', 'TaskController@dataSaveTaskItem');
Route::post('/data-task-update-message', 'TaskController@dataTaskUpdateMessage');

Route::post('/data-save-user', 'AuthenticationController@dataSaveUser');

Route::get('/data-all-groups/{id}', 'GroupController@dataAllGroups');
Route::get('/data-all-group-members/{groupId}', 'GroupController@dataAllGroupMembers');
Route::get('/data-all-groups-count/{id}', 'GroupController@dataAllGroupsCount');
Route::post('/data-remove-group-members/{id}', 'GroupController@dataRemoveGroupMembers');
Route::post('/data-save-group', 'GroupController@dataSaveGroup');

Route::get('/data-all-contacts/{id}', 'ContactController@dataAllContacts');
Route::get('/data-all-contacts-count', 'ContactController@dataAllContactsCount');
Route::get('/data-remove-contacts', 'ContactController@dataRemoveContacts');
Route::post('/data-add-contact', 'ContactController@dataAddContact');
Route::post('/find-contact-by-email', 'ContactController@dataFindContactByEmail');

/********************** json methods for apps ********************/