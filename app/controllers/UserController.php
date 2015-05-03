<?php

class UserController extends BaseController {

	public function userSection()
	{
		return View::make('user.user-section');
	}

}