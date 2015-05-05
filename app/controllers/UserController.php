<?php

class UserController extends BaseController {

	public function userSection()
	{
        $user_id = Session::get('user');

        $user = User::find($user_id);

        if(isset($user)){
    		return View::make('user.user-section')->with('user', $user);
        }
        else
            return Redirect::to('/');
	}

    public function findGroupMemberByEmail(){

        $email = Input::get('email');

        $user = User::where('email', '=', $email)->first()->toArray();

        if(isset($user))
            return array('found' => 'yes', 'user' => $user);
        else
            return array('found' => 'no');
    }

    public function memberRequestCount(){
        $user_id = Session::get('user');

        $user = User::find($user_id);

        if(isset($user)){

            $count = GroupMember::where('user_id', '=', $user_id)->where('status', '=', 'pending')->count();

            return $count;
        }
        else
            return 0;
    }

    public function newMemberRequests(){
        return View::make('user.new-member-requests');
    }

    public function dataNewMemberRequests(){

        $user_id = Session::get('user');

        $user = User::find($user_id);

        if(isset($user)){

            $requests = GroupMember::where('user_id', '=', $user_id)->where('status', '=', 'pending')->with('userGroup')->get();

            if(isset($requests) && count($requests)>0){
                return array('requests' => $requests->toArray(), 'request_by' => $user->toArray());
            }
            else
                return array();
        }
        else
            return array();
    }
}