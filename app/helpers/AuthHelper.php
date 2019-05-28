<?php

class AuthHelper extends BaseController {

	public static function checkUser() {
		$users = ['oneone', 'elisa', 'gliedt', 'shahidm'];
		
		if(!Session::has('user')) {
			return false;
		}

		if(Session::has('user')) {
			if(!in_array(Session::get('user'), $users)) {
				return false;
			}
		}

		return true;
	}

	public static function authCheck($msg = '') {
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('http://www.google.com');
		}
		LogHelper::logcms("\n". $msg);

		return true;
	}

	public static function logout() {
		Auth::logout();
		Session::forget('auth');
		return Redirect::to('/login');
	}
}