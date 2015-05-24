<?php

class AuthenticationController extends BaseController {

	public function login(){
		return View::make('authentication.login');
	}

	public function adminLogin(){
		return View::make('authentication.admin-login');
	}
	
	public function register(){
		return View::make('authentication.register');
	}
	
	public function passwordRecovery(){
		return View::make('authentication.password-recovery');
	}
	
	public function passwordSent(){
		return View::make('authentication.password-sent');
	}

    public function isValidAdmin()
    {
        $username = Input::get('username');
        $password = Input::get('password');

        $admin = Admin::where('username', '=', $username)
                        ->where('password','=',$password)->first();

        if(is_null($admin))
            return "invalid";
        else{
            Session::put('admin_id', $admin->id);

            return "correct";
        }
    }

	public function isValidUser()
	{
        $email = Input::get('email');
        $password = Input::get('password');

        $user = User::where('email', '=', $email)
                    ->where('password','=',$password)->first();

        if(isset($user)){

            if($user->status=='active'){

                Session::put('user', $user->id);

                echo json_encode(array('id' => $user->id, 'message' => 'correct'));
            }
            else if($user->status=='pending')
                echo json_encode(array('message' => 'inactive'));
            else if($user->status=='removed')
                echo json_encode(array('message' => 'removed'));
        }
        else
            echo json_encode(array('message' => 'wrong'));
	}

    public function isDuplicateUser($email)
    {
        $user = User::where('email', '=', $email)->first();

        return isset($user) ? 'yes' : 'no';
    }

    public function saveUser(){

        $email = Input::get('email');

        if($this->isDuplicateUser($email)==="no"){

            $user = new User;

            $user->first_name = Input::get('first_name');
            $user->last_name = Input::get('last_name');
            $user->display_name = Input::get('display_name');
            $user->email = Input::get('email');
            $user->password = Input::get('password');
            $user->gender = Input::get('gender');
            $user->country = Input::get('country');
            $user->activation_code = "AT" . $this->getCurrentTime();
            $user->status = 'pending';
            $user->created_at = date("Y-m-d h:i:s");
            $user->updated_at = date("Y-m-d h:i:s");

            $user->save();

            Session::put('name', $user->first_name);

            //$this->sendUserEmail($user);

            echo 'created';
        }
        else
            echo 'duplicate';
    }

    public function getCurrentTime(){
        $timeParts = explode(" ",microtime());
        $currentTime = bcadd(($timeParts[0]*1000),bcmul($timeParts[1],1000));

        return $currentTime;
    }

    public function registered(){

        $name = Session::get('name');

        if(isset($name)){

            Session::forget('name');

            return View::make('authentication.registered');
        }
        else
            return Redirect::to('/');
    }

    public function sendPassword(){

        $email = Input::get('email');

        $user = User::where('User.email','=',$email)->first();

        $data = array('name'=>$user->name);

        Mail::send('emails.resetpassword', $data, function($message)use ($user){

            $message->to($user->email, $user->name)->subject('You requested your password');
        });
    }

    public function sendUserEmail($user){

        ini_set('max_execution_time',3600);

        $data = array('user'=>$user);

        Mail::send('emails.usermail', $data, function($message)use ($user){

            $name = $user->first_name . " " . $user->last_name;

            $message->to($user->email, $name)->subject('Greetings from active task');
        });
    }

    public function activateAccount($code){

        $user = User::where('activation_code', '=', $code)->first();

        if(isset($user)){

            $user->status = 'active';

            $user->save();

            Session::put('activation_code', $code);

            return Redirect::to('/account-activated');
        }
        else
            return Redirect::to('/');
    }

    public function accountActivated(){

        $code = Session::get('activation_code');

        if(isset($code)){

            Session::forget('activation_code');

            return View::make('authentication.account-activated');
        }
        else
            return Redirect::to('/');
    }

    public function logout(){

        Session::flush();

        return Redirect::to('/');
    }

/*************************** app methods ************************/

    public function dataSaveUser(){

        $email = Input::get('email');

        if($this->isDuplicateUser($email)==="no"){

            $user = new User;

            $user->first_name = Input::get('first_name');
            $user->last_name = Input::get('last_name');
            $user->display_name = Input::get('display_name');
            $user->email = Input::get('email');
            $user->password = Input::get('password');
            $user->gender = Input::get('gender');
            $user->country = Input::get('country');
            $user->activation_code = "AT" . $this->getCurrentTime();
            $user->status = 'pending';
            $user->created_at = date("Y-m-d h:i:s");
            $user->updated_at = date("Y-m-d h:i:s");

            $user->save();

            Session::put('name', $user->first_name);

            //$this->sendUserEmail($user);

            echo 'created';
        }
        else
            echo 'duplicate';
    }
}