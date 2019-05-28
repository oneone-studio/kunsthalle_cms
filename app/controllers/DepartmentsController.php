<?php

class DepartmentsController extends BaseController {

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
		$departments = Department::with('contact')->get()->sortBy('sort_order');	

		return View::make('pages.departments.index', ['departments' => $departments]);
	}

	public function show()
	{
		// $events = Event::all();	
		return View::make('pages.departments.index');//, ['events' => ['apples', 'oranges', 'mangoes'] ] ); // $events] );
	}

	public function create()
	{
		$departments = Department::all();

		return View::make('pages.departments.create', ['departments' => $departments]);
	}

	public function edit($id)
	{
		$department = Department::with('contact')->findOrFail($id);

		return View::make('pages.departments.edit', [ 'department' => $department ]);
	}

	public function updateOrder($id, $order) {
		$department = Department::find($id);	
		$department->sort_order = $order;
		$department->save();

        return Redirect::action('DepartmentsController@index');
	}

	public function update()
	{
		$department = Department::with('contact')->findOrFail(Input::get('id'));

		$department->title_de = Input::get('title_de');
		$department->title_en = Input::get('title_en');
		$department->save();

        return Redirect::action('DepartmentsController@index');
	}
	
	public function destroy($id) {
		Department::destroy($id);

		return Redirect::action('DepartmentsController@index');
	}

	public function store()
	{
		$input = Input::all();
		$dts = Department::all();
		$new_order = count($dts) + 1;

		$department = new Department;
		$department->title_de = Input::get('title_de');
		$department->title_en = Input::get('title_en');
		$department->sort_order = $new_order;
		$department->save();

        return Redirect::action('DepartmentsController@index');
	}

	public function test() {
		return View::make('pages.departments.test');
	}


}
