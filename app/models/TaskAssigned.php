<?php

class TaskAssigned extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'task_assigned';

	protected $hidden = array();

    public function group()
    {
        return $this->belongsTo('Group');
    }

    public function contact()
    {
        return $this->belongsTo('Contact');
    }
}