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
                $tasks = Task::where('status', '=', 'active')->where('user_id', '=', $userId)->get();

                if(isset($tasks) && count($tasks)>0)
                    return array('message' => 'found', 'tasks' => $tasks->toArray());
                else
                    return array('message', 'empty');
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

                $contactQuery = "select id,name,description,start_date,end_date from tasks where id in(
                                    select task_id from task_items where assigned_to='contact' and id in(
                                        select task_item_id from task_assigned where contact_id in(
                                            select contact_id from contacts where user_id=$userId
                                        )
                                    )
                              )";

                $groupQuery = "select id,name,description,start_date,end_date from tasks where id in(
                                    select task_id from task_items where assigned_to='group' and id in(
                                        select task_item_id from task_assigned where group_id in(
                                            select group_id from group_members where user_id=$userId
                                        )
                                    )
                              )";

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
                    return array('message' => 'found', 'tasks' => $tasks);
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

                if(isset($taskItems) && count($taskItems)>0)
                    return array('message' => 'found', 'taskItems' => $taskItems->toArray());
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

                $contactQuery = "select id,description,start_date,end_date from task_items where id in(
                                        select task_item_id from task_assigned where contact_id in(
                                            select contact_id from contacts where user_id=$userId
                                        )
                              )";

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
                            'end_date' => $taskItem['end_date']
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
        $user_id = Input::get('user_id');
        $message = Input::get('message');
        $type = Input::get('type');
        $task_item_id = Input::get('task_item_id');

        $taskComment = new TaskComment();

        $taskComment->user_id = $user_id;
        $taskComment->task_item_id = $task_item_id;
        $taskComment->message = $message;
        $taskComment->status = $type;

        $taskComment->save();

        if($type=='Complete' || $type=='Failed'){
            
            $taskItem = TaskItem::find($task_item_id);

            $taskItem->status = $type;

            $taskItem->save();
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