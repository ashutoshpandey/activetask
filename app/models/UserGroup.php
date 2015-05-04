<?php

class UserGroup extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user_groups';

	protected $hidden = array();

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function groupMembers()
    {
        return $this->hasMany('GroupMember');
    }
}