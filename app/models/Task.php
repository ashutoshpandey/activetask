<?php

class Task extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tasks';

	protected $hidden = array();

    public function taskItems()
    {
        return $this->hasMany('TaskItem');
    }
}