<?php

class Task extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'task_items';

	protected $hidden = array();

    public function taskItems()
    {
        return $this->belongsTo('Task');
    }
}