<?php

class GroupMember extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'group_members';

	protected $hidden = array();

    public function userGroup()
    {
        return $this->belongsTo('UserGroup');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }
}