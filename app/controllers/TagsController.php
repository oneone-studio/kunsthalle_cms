<?php

class TagsController extends BaseController {

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
		$tags = Tag::with('k_events')->get();	

		return View::make('pages.tags.index', ['tags' => $tags]);
	}

	public function show()
	{
		// $events = Event::all();	

		return View::make('pages.tags.index');//, ['events' => ['apples', 'oranges', 'mangoes'] ] ); // $events] );
	}

	public function create()
	{
		$k_events = Tag::all();
		$tags = Tag::all();

		return View::make('pages.tags.create', ['k_events' => $k_events, 'tags' => $tags]);
	}

	public function edit($id)
	{
		$tag = Tag::with('k_events')->findOrFail($id);
		$k_events = Tag::all();
		$tags = Tag::all();

		return View::make('pages.tags.edit', [ 'tag' => $tag, 'k_events' => $k_events, 'tags' => $tags ]);
	}

	public function update()
	{

		$tag = Tag::with('k_events')->findOrFail(Input::get('id'));

		$tag->tag_de = Input::get('tag_de');
		$tag->tag_en = Input::get('tag_en');
		$tag->save();

        return Redirect::action('TagsController@index');
	}
	
	public function destroy($id) {
		Tag::destroy($id);

		return Redirect::action('TagsController@index');
	}

	public function store()
	{
		$input = Input::all();

		$tag = new Tag;
		$tag->tag_de = Input::get('tag_de');
		$tag->tag_en = Input::get('tag_en');
		$tag->save();

        return Redirect::action('TagsController@index');
	}

	public function test() {
		return View::make('pages.tags.test');
	}


}
