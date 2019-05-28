<?php
 
class UserController extends Controller
{
  public function login()
  {
    return View::make("pages.user.login");
  }

  public function authenticate() {
 	$rules = array(
	    'username'    => 'required|alphaNum', // make sure the email is an actual email
	    'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
	);
	// run the validation rules on the inputs from the form
	$validator = Validator::make(Input::all(), $rules);
	// if the validator fails, redirect back to the form
	if ($validator->fails()) {
	    return Redirect::to('/login')
	        ->withErrors($validator)
	        ->withInput(Input::except('password'))->with('message', 'Login Failed'); // send back the input (not the password) so that we can repopulate the form
	} else {

	    // create our user data for the authentication
	    $userdata = array(
	        'username'     => Input::get('username'),
	        'password'  => Input::get('password')
	    );
		// print_r($userdata); exit;
	    // attempt to do the login
	    if (Auth::attempt($userdata, true)) {

	    	Session::put('auth', true);
			// echo '>>>  '. Auth::id(); exit;
    		Session::put('is_admin', true);
    		Session::put('user', Input::get('username'));
	    	return Redirect::to('/content/events');

	    } else {        
	    	$validator->getMessageBag()->add('password', 'Incorrect password');
	        return Redirect::to('/login')->withErrors($validator)->withInput(); //->with('message', 'Login Failed');;
	    }
	}  	
  }

  public function accounts() {
	$accounts = User::all();
	// echo '<pre>'; print_r($accounts); exit;
	return View::make('pages.user.index', ['accounts' => $accounts]);
  }

  public function sendMassEmail() {
  	// $f = fopen('/Applications/MAMP/htdocs/weef_cms.log', 'w+');
  	// fwrite($f, "send Mail..\n\n");
  	if(Input::has('mail_type')) {
  		$ids = Input::get('ids');
  		if(count($ids)) {
			$accounts = User::all();
			foreach($accounts as $ac) {
				$to_name = $ac->name;
				$to_email = $ac->email;
				$data = [
						   'name' => $ac->name,
						   'password' => $ac->password_text,
						   'email' => $ac->email
						];
				if(isset($to_email)) {
					// fwrite($f, $to_name . ' : '. $to_email . "\n");
			    	Mail::send(['html'=>'emails.user.mail'], $data, function($message) {
			        $message->to('shahidm08@gmail.com', 'ok')
			                 ->subject('AKG Support')
			                 ->from('manzoor@oneone-studio.com', 'AKG Support');
			        });
				}			
			}
  		}
  	}
  }

  public function showPage(Request $request, User $user) {
	   $this->ensureOwnsPage($user);
	   // Everything fine, user owns the page so serve the page
  }

  protected function ensureOwnsPage($user) {
	 if (Auth::user()->id !== $user->id) {
	    throw new Exception("Unauthorized access");
	 }
  }

  public function updateProfilePwd() {
  	// $profiles = Profile::take(50)->get();
  	$profiles = Profile::offset(50)->take(63)->get();  	
  	$pws = [];
  	$cnt = 0;
  	$str = 'XyIusZwRpxr73Tsf9y54stWGBeC4VEcNk2OpKJqPbzMngH';  	
	$pw_text = substr(str_shuffle($str), 0, 12);
	$pw = Hash::make($pw_text);
echo $pw_text . '<br>'. $pw;
  	// foreach($profiles as $p) {
  	// 	++$cnt;
  	// 	echo '<br>REC: ' . $cnt;
  	// 	if($p->profile_type != 'admin') {
	  // 		$pw_text = substr(str_shuffle($str), 0, 12);
	  // 		$pw = Hash::make($pw_text);
			// DB::table('profiles')
			// 	->where('id', $p->id)
			// 	->update(['password' => $pw, 'password_text' => $pw_text]); 
  	// 	}
  	// }
		echo '<br>-- Done --'; exit;
  }

  public function doLogout() {
  	 Auth::logout();
  	 Session::forget('auth');
  	 return Redirect::to('/login');
  }  

}