<?php

class TaskController extends BaseController {

    public function create(){
        return View::make('task.create');
    }

	public function save()
	{
        $user_id = Session::get('user');

        $group_id = Input::get('group_id');

        $name = Input::get('name');
        $task_type = Input::get('task_type');
        $description = Input::get('description');
        $others_can_add = Input::get('others_can_add');
        $start_date = Input::get('start_date');
        $end_date = Input::get('end_date');

        $task = new Task();

        $task->name = $name;
        $task->user_id = $user_id;

        if(isset($group_id))
            $task->group_id = $group_id;

        $task->task_type = $task_type;
        $task->description = $description;
        $task->others_can_add = $others_can_add;
        $task->start_date = date('Y-m-d h:i:s', strtotime($start_date));
        $task->end_date = date('Y-m-d h:i:s', strtotime($end_date));
        $task->status = 'active';

        $task->save();

        echo 'created';
	}

    public function find($id)
    {
        $task = Task::find($id);

        if(isset($task))
            return $task;
        else
            return null;
    }

    public function edit($id){

        $task = Task::find($id);

        if(isset($task)){
            Session::put('edit_task_id', $id);

            return View::make('task.edit')->with('task', $task)->with('found', true);
        }
        else
            return View::make('task.edit')->with('found', false);
    }

    public function update()
    {
        $task_id = Session::get('edit_task_id');

        $task = Task::find($task_id);

        if(isset($task)){

            $name = Input::get('name');
            $group_id = Input::get('group_id');
            $task_type = Input::get('task_type');
            $allow_adding_task_item = Input::get('allow_adding_task_item');
            $start_date = Input::get('start_date');
            $end_date = Input::get('end_date');

            $task = new Task();

            $task->name = $name;
            $task->group_id = $group_id;
            $task->task_type = $task_type;
            $task->allow_adding_task_item = $allow_adding_task_item;
            $task->start_date = $start_date;
            $task->end_date = $end_date;
            $task->status = 'active';

            $task->save();

            echo 'updated';
        }
        else
            echo 'invalid';
    }

    public function remove($id)
    {
        $task = Task::find($id);

        if(isset($task)){
            $task->status = 'removed';

            $task->save();

            echo 'removed';
        }
        else
            echo 'invalid';
    }

    public function all()
    {
        $user_id = Session::get('user');

        $tasks = Task::where('status', '=', 'active')->where('user_id', '=', $user_id)->get();

        $found = isset($tasks) && count($tasks)>0;

        return View::make('task.all')->with('tasks', $tasks)->with('found', $found);
    }

    public function saveTaskItem()
    {
        $user_id = Session::get('user');
        $task_id = Session::get('task_id');

        $assigned_to = Input::get('assigned_to');
        $content = Input::get('content');
        $start_date = Input::get('start_date');
        $end_date = Input::get('end_date');

        $taskItem = new TaskItem();

        $taskItem->assigned_to = $assigned_to;
        $taskItem->user_id = $user_id;
        $taskItem->task_id = $task_id;
        $taskItem->content = $content;
        $taskItem->start_date = $start_date;
        $taskItem->end_date = $end_date;
        $taskItem->status = 'active';

        $taskItem->save();

        echo 'created';
    }

    public function taskItems($id)
    {
        $task = Task::find($id);

        if(isset($task)){

            Session::put('task_id', $id);

            $taskItems = TaskItem::where('status', '=', 'active')->where('task_id', '=', $id)->get();

            return View::make('task.task-items')->with('taskItems', $taskItems);
        }
        else
            return Redirect::to('/');
    }

    public function removeTaskItem($id)
    {
        $taskItem = TaskItem::find($id);

        if(isset($taskItem)){
            $taskItem->status = 'removed';

            $taskItem->save();

            echo 'removed';
        }
        else
            echo 'invalid';
    }

    /************************ json data methods ***************************/

    public function removeTaskItems()
    {
        $ids = Input::get('ids'); // comma separated ids, to be removed

        if (isset($ids)) {

            $ar_ids = explode(',', $ids);

            if(isset($ar_ids)){

                foreach($ar_ids as $id){

                    TaskItem::where('id', '=', $id)->delete();
                }

                echo 'removed';
            }
        }
        else
            echo 'invalid';
    }

    /************************ json data methods for app ***************************/

    public function dataAllTasks($userId)
    {
        if(isset($userId)){

            $user = User::find($userId);

            if(isset($user)){
                $tasks = Task::where('user_id', '=', $userId)->get();

                if(isset($tasks) && count($tasks)>0){

                    $tasksArray = array();

                    $pendingCount = 0;

                    foreach($tasks as $task){

                        $total = TaskItem::whereIn('status', array('active','complete','failed'))->where('user_id', '=', $userId)->count();
                        $completed = TaskItem::whereIn('status', array('complete','failed'))->where('user_id', '=', $userId)->count();

                        $tasksArray[] = array(
                            "id" => $task->id,
                            "user_id" => $task->user_id,
                            "name" => $task->name,
                            "task_type" => $task->task_type,
                            "others_can_add" => $task->others_can_add,
                            "description" => $task->description,
                            "start_date" => $task->start_date,
                            "end_date" => $task->end_date,
                            "status" => $task->status,
                            "total" => $total,
                            "completed" => $completed
                        );

                        if($total!=$completed)
                            $pendingCount++;
                    }

                    return array('message' => 'found', 'tasks' => $tasksArray, 'pending' => $pendingCount);
                }
                else
                    return array('message' => 'empty');
            }
            else
                return array('message' => 'empty');
        }
        else
            return array('message' => 'empty');
    }

    public function dataAllAssignedTasks($userId)
    {
        if(isset($userId)){

            $user = User::find($userId);

            if(isset($user)){
//                $tasks = TaskAssigned::where('status', '=', 'active')->where('user_id', '=', $userId)->where('assign_type', '=', 'contact')->with('task')->get();
                $tasks = array();

                $contactQuery = "select id,name,description,start_date,end_date,status from tasks where id in(
                                    select task_id from task_items where assigned_to='contact' and id in(
                                        select task_item_id from task_assigned where contact_id in(
                                            select contact_id from contacts where user_id=$userId
                                        )
                                    )
                              )";

                $groupQuery = "select id,name,description,start_date,end_date,status from tasks where id in(
                                    select task_id from task_items where assigned_to='group' and id in(
                                        select task_item_id from task_assigned where group_id in(
                                            select group_id from group_members where user_id=$userId
                                        )
                                    )
                              )";

                $pendingCount = 0;

                $tasksContact = DB::select(DB::raw($contactQuery));
                if(isset($tasksContact)){
                    foreach($tasksContact as $taskObj){
                        $task = get_object_vars($taskObj);
                        $tasks[] = array(
                            'id' => $task['id'],
                            'name' => $task['name'],
                            'description' => $task['description'],
                            'start_date' => $task['start_date'],
                            'end_date' => $task['end_date']
                        );

                        if($task['status']=='active')
                            $pendingCount++;
                    }
                }

                $tasksGroup = DB::select(DB::raw($groupQuery));
                if(isset($tasksGroup)){
                    foreach($tasksGroup as $taskObj){
                        $task = get_object_vars($taskObj);
                        $tasks[] = array(
                            'id' => $task['id'],
                            'name' => $task['name'],
                            'description' => $task['description'],
                            'start_date' => $task['start_date'],
                            'end_date' => $task['end_date']
                        );
                    }
                }

                if(isset($tasks) && count($tasks)>0)
                    return array('message' => 'found', 'tasks' => $tasks, 'pending' => $pendingCount);
                else
                    return array('message' => 'empty');
            }
            else
                return array('message' => 'empty');
        }
        else
            return array('message', 'empty');
    }

    public function dataAllTaskItems($taskId)
    {
        if(isset($taskId)){

            $task = Task::find($taskId);

            if(isset($task)){

                $taskItems = TaskItem::where('status', '=', 'active')->where('task_id', '=', $taskId)->get();

                if(isset($taskItems) && count($taskItems)>0){

                    $arTaskItems = array();

                    foreach($taskItems as $taskItem){

                        $taskItemId = $taskItem->id;

                        $assigned_name = array();

                        if($taskItem->assigned_to=='group'){
                            $taskAssigned = TaskAssigned::where('task_item_id', '=', $taskItemId)->where('status', '=', 'active')->first();

                            if(isset($taskAssigned)){
                                $group = UserGroup::find($taskAssigned->group_id);

                                if(isset($group))
                                    $assigned_name[] = $group->name;
                            }
                        }
                        else if($taskItem->assigned_to=='contact'){

                            $tasksAssigned = TaskAssigned::where('task_item_id', '=', $taskItemId)->where('status', '=', 'active')->get();

                            if(isset($tasksAssigned)){

                                foreach($tasksAssigned as $taskAssigned){
                                    $contact = Contact::find($taskAssigned->contact_id);

                                    if(isset($contact)){
                                        $assigned_name[] = $contact->user->first_name . ' ' . $contact->user->last_name;
                                    }
                                }
                            }
                        }

                        $arTaskItems[] = array(
                            'id' => $taskItem->id,
                            'task_id' => $taskItem->task_id,
                            'user_id' => $taskItem->user_id,
                            'description' => $taskItem->description,
                            'assigned_to' => $taskItem->assigned_to,
                            'start_date' => $taskItem->start_date,
                            'end_date' => $taskItem->end_date,
                            'status' => $taskItem->status,
                            'assigned_name' => implode(',',$assigned_name)
                        );
                    }

                    return array('message' => 'found', 'taskItems' => $arTaskItems);
                }
                else
                    return array('message' => 'empty');
            }
            else
                return array('message' => 'empty');
        }
        else
            return array('message' => 'empty');
    }

    public function dataAllAssignedTaskItems()
    {
        $taskId = Input::get('task_id');
        $userId = Input::get('user_id');

        if(isset($taskId) && isset($userId)){

            $task = Task::find($taskId);
            $user = User::find($userId);

            if(isset($task) && isset($user)){

                $contactQuery = "select task_items.id as id,description,start_date,end_date,contact_id from task_items
                                 inner join task_assigned on task_items.id=task_assigned.task_item_id
                                 where task_items.task_id=$taskId and
                                 task_assigned.contact_id=(select id from contacts where user_id=$userId)";

                $groupQuery = "select id,description,start_date,end_date from task_items where id in(
                                        select task_item_id from task_assigned where group_id in(
                                            select group_id from group_members where user_id=$userId
                                        )
                              )";

                $taskItems = array();

                $tasksContact = DB::select(DB::raw($contactQuery));
                if(isset($tasksContact)){
                    foreach($tasksContact as $taskItemObj){
                        $taskItem = get_object_vars($taskItemObj);
                        $taskItems[] = array(
                            'id' => $taskItem['id'],
                            'description' => $taskItem['description'],
                            'start_date' => $taskItem['start_date'],
                            'end_date' => $taskItem['end_date'],
                            'contact_id' => $taskItem['contact_id']
                        );
                    }
                }

                $tasksGroup = DB::select(DB::raw($groupQuery));
                if(isset($tasksGroup)){
                    foreach($tasksGroup as $taskItemObj){
                        $taskItem = get_object_vars($taskItemObj);
                        $taskItems[] = array(
                            'id' => $taskItem['id'],
                            'description' => $taskItem['description'],
                            'start_date' => $taskItem['start_date'],
                            'end_date' => $taskItem['end_date']
                        );
                    }
                }

//                $taskItems = TaskItem::where('status', '=', 'active')->where('task_id', '=', $taskId)->get();

                if(isset($taskItems) && count($taskItems)>0)
                    return array('message' => 'found', 'taskItems' => $taskItems);
                else
                    return array('message' => 'empty');
            }
            else
                return array('message' => 'empty');
        }
        else
            return array('message' => 'empty');
    }

    public function dataPendingTasksCount($id)
    {
        if(isset($id)){

            $user = User::find($id);

            if(isset($user)){
                $count = Task::where('status', '=', 'active')->where('user_id', $id)->count();

                return array('count' => $count);
            }
            else
                return array('count' => 0);
        }
        else
            return array();
    }

    public function dataSaveTask()
    {
        $user_id = Input::get('user_id');
        $name = Input::get('name');
        $task_type = Input::get('task_type');
        $description = Input::get('description');
        $others_can_add = 'n'; //Input::get('others_can_add');
        $start_date = Input::get('start_date');
        $end_date = Input::get('end_date');

        $task = new Task();

        $task->name = $name;
        $task->user_id = $user_id;
        $task->task_type = $task_type;
        $task->description = $description;
        $task->others_can_add = $others_can_add;
        $task->start_date = date('Y-m-d h:i:s', strtotime($start_date));
        $task->end_date = date('Y-m-d h:i:s', strtotime($end_date));
        $task->status = 'active';

        $task->save();

        echo 'created';
    }

    public function dataTaskUpdateMessage()
    {
        $contact_id = Input::get('contact_id');
        $message = Input::get('message');
        $type = Input::get('type');
        $task_item_id = Input::get('task_item_id');

        $taskComment = new TaskComment();

        $taskComment->contact_id = $contact_id;
        $taskComment->task_item_id = $task_item_id;
        $taskComment->message = $message;
        $taskComment->status = strtolower($type);

        $taskComment->save();

        // update task assigned
        if($type=='complete' || $type=='failed'){

            $contact = Contact::where('id', '=', $contact_id)->first();

            if(isset($contact)){

                $taskAssigned = TaskAssigned::where('task_item_id','=',$task_item_id)->where('contact_id','=',$contact_id)->first();

                if(isset($taskAssigned)){
                    $taskAssigned->status = $type;

                    $taskAssigned->save();

                    // update task item if all task assigned are completed
                    $activeCount = $taskAssigned::where('task_item_id','=',$task_item_id)->where('status','=','active')->count();

                    if(isset($activeCount) && $activeCount==0){
                        $taskItem = TaskItem::find($task_item_id);

                        if(isset($taskItem)){

                            $taskItem->status = 'complete';

                            $taskItem->save();
                        }
                    }
                }
            }
        }

        echo 'saved';
    }

    public function dataSaveTaskItem()
    {
        $user_id = Input::get('user_id');
        $task_id = Input::get('task_id');
        $assigned_to = Input::get('assigned_to');
        $assigned_ids = Input::get('assigned_ids');
        $description = Input::get('description');
        $start_date = Input::get('start_date');
        $end_date = Input::get('end_date');

        $taskItem = new TaskItem();

        $taskItem->task_id = $task_id;
        $taskItem->user_id = $user_id;
        $taskItem->assigned_to = $assigned_to;          // contacts, group
        $taskItem->description = $description;
        $taskItem->start_date = date('Y-m-d h:i:s', strtotime($start_date));
        $taskItem->end_date = date('Y-m-d h:i:s', strtotime($end_date));
        $taskItem->status = 'active';

        $taskItem->save();

        if($assigned_to=="group"){
            $taskAssigned = new TaskAssigned();

            $taskAssigned->task_item_id = $taskItem->id;
            $taskAssigned->status = 'active';
            $taskAssigned->assign_type = $assigned_to;
            $taskAssigned->group_id = $assigned_ids;

            $taskAssigned->save();
        }
        else if($assigned_to=="contact"){

            $ar = explode(',', $assigned_ids);

            if(isset($ar) && count($ar)>0){

                foreach($ar as $id){
                    $taskAssigned = new TaskAssigned();

                    $taskAssigned->task_item_id = $taskItem->id;
                    $taskAssigned->status = 'active';
                    $taskAssigned->assign_type = $assigned_to;
                    $taskAssigned->contact_id = $id;

                    $taskAssigned->save();
                }
            }
        }


        echo 'created';
    }
}