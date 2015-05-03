<?php

class TaskController extends BaseController {

    public function create(){
        return View::make('tasks.create');
    }

	public function save()
	{
        $user_id = Session::get('user');

        $name = Input::get('name');
        $group_id = Input::get('group_id');
        $task_type = Input::get('task_type');
        $description = Input::get('description');
        $allow_adding_task_item = Input::get('allow_adding_task_item');
        $start_date = Input::get('start_date');
        $end_date = Input::get('end_date');

        $task = new Task();

        $task->name = $name;
        $task->user_id = $user_id;
        $task->group_id = $group_id;
        $task->task_type = $task_type;
        $task->allow_adding_task_item = $allow_adding_task_item;
        $task->start_date = $start_date;
        $task->end_date = $end_date;
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

            return View::make('tasks.edit')->with('task', $task)->with('found', true);
        }
        else
            return View::make('tasks.edit')->with('found', false);
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

        return View::make('tasks.all')->with('tasks', $tasks)->with('found', $found);
    }

    public function addTaskItem($id){

        $task = Task::find($id);

        if(isset($task)){
            Session::put('add_task_item_id', $id);

            return View::make('task.add-task-item')->with('task', $task)->with('found', true);
        }
        else
            return View::make('task.add-task-item')->with('found', false);
    }

    public function saveTaskItem()
    {
        $user_id = Session::get('user');
        $task_id = Session::get('add_task_item_id');

        $name = Input::get('name');
        $description = Input::get('description');
        $start_date = Input::get('start_date');
        $end_date = Input::get('end_date');

        $task = new Task();

        $task->name = $name;
        $task->user_id = $user_id;
        $task->task_id = $task_id;
        $task->description = $description;
        $task->start_date = $start_date;
        $task->end_date = $end_date;
        $task->status = 'active';

        $task->save();

        echo 'created';
    }

    public function taskItems($id)
    {
        $task = Task::find($id);

        if(isset($task)){

            $taskItems = TaskItem::where('status', '=', 'active')->where('task_id', '=', $id)->get();

            return $taskItems;
        }
        else
            return null;
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

    public function allTasks()
    {
        $user_id = Session::get('user');

        $tasks = Task::where('status', '=', 'active')->where('user_id', '=', $user_id)->get();

        if(isset($tasks) && count($tasks)>0)
            return $tasks;
        else
            return null;
    }

    public function allTaskItems($id)
    {
        $taskItems = TaskItem::where('status', '=', 'active')->where('task_id', '=', $id)->get();

        if(isset($taskItems) && count($taskItems)>0)
            return $taskItems;
        else
            return null;
    }

}