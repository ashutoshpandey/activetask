<?php

class TaskComment extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'task_comments';

	protected $hidden = array();

    public function taskItem()
    {
        return $this->belongsTo('TaskItem');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }
}