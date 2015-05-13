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
                return array('message', 'empty');
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
}