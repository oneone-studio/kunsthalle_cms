<?php

class ContactsController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function index()
	{
		$contacts = Contact::with('department')->get()->sortBy('first_name');	

		return View::make('pages.contacts.index', ['contacts' => $contacts]);
	}

	public function show()
	{
		return View::make('pages.contacts.index');
	}

	public function create()
	{
		$depts = Department::all()->sortBy('sort_order');
		$count = 1;
		$res = DB::select('select count(id) as cnt from contacts');
		if($res) { $count = $res[0]->cnt; }

		return View::make('pages.contacts.create', ['depts' => $depts, 'contact_count' => $count]);
	}

	public function edit($id)
	{
		$contact = Contact::findOrFail($id);
		$count = 1;
		$res = DB::select('select count(id) as cnt from contacts');
		if($res) { $count = $res[0]->cnt; }
		$depts = Department::all()->sortBy('sort_order');

		return View::make('pages.contacts.edit', ['contact' => $contact, 'depts' => $depts, 'contact_count' => $count]);
	}

	public function update()
	{
		// echo '<pre>'; print_r(Input::all()); exit;
		$contact = Contact::findOrFail(Input::get('id'));
		$contact->first_name = Input::get('first_name');
		$contact->last_name = Input::get('last_name');
		$contact->title = Input::get('title');
		$contact->department_id = Input::get('department');
		$contact->function = Input::get('function');
		$contact->phone = Input::get('phone');
		$contact->email = Input::get('email');
		$contact->sort_order = Input::get('sort_order');
		$contact->display = Input::get('display');
		$contact->save();

        return Redirect::action('ContactsController@index');
	}
	
	public function destroy($id) {
		Contact::destroy($id);

		return Redirect::action('ContactsController@index');
	}

	public function store()
	{
		$contact = new Contact;
		$contact->first_name = Input::get('first_name');
		$contact->last_name = Input::get('last_name');
		$contact->title = Input::get('title');
		$contact->department_id = Input::get('department');
		$contact->function = Input::get('function');
		$contact->phone = Input::get('phone');
		$contact->email = Input::get('email');
		$contact->sort_order = Input::get('sort_order');
		$contact->display = Input::get('display');
		$contact->save();

        return Redirect::action('ContactsController@index');
	}
}
