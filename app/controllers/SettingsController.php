<?php

class SettingsController extends BaseController {

	public function index()
	{
		$set = Settings::first();
		// echo '<pre>'; print_r($set); exit;
		$data = [];
		$data['settings'] = $set;
		
		$user = User::where('username', 'admin')->first();
		if($user) {
			$data['user'] = $user;
		}

		return View::make('pages.settings', ['data' => $data]);
	}

	public function edit() {
		$data = [];
		$set = Settings::first();
		$data['settings'] = $set;
		
		$user = User::where('username', 'admin')->first();
		if($user) {
			$data['user'] = $user;
		}

		return View::make('pages.settings', ['data' => $data]);
	}

	public function save() {
		DB::table('settings')->delete();
		$set = new Settings();
		$set->dl_password = Input::get('dl_password');
		$set->save();

		if(Input::has('admin_password') && strlen(trim(Input::get('admin_password'))) > 0) {
			$user = User::where('username', 'admin')->first();
			if($user) {
				$hash = '$2y$04$usesomesillystringfore7hnbRJHxXVLeakoG8K30oukPsA.ztMG';
				$admin_pw = crypt(Input::get('admin_password'), $hash);
				$user->password = $admin_pw;
				$user->password_text = Input::get('admin_password');
				$user->save();
			}
		}

		return Redirect::action('SettingsController@index');
	}
}
