<?php

class TeasersExbController extends BaseController {

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
		$teasers = Teaser::get();	

		return View::make('pages.teasers.index', ['teasers' => $teasers]);
	}

	public function show()
	{
		// $events = Event::all();	

		return View::make('pages.teasers.index');//, ['events' => ['apples', 'oranges', 'mangoes'] ] ); // $events] );
	}

	public function create()
	{
		return View::make('pages.teasers.create');
	}

	public function edit($id)
	{
		$teaser = Teaser::findOrFail($id);

		return View::make('pages.teasers.edit', ['teaser' => $teaser]);
	}

	public function update()
	{
		$teaser = Teaser::findOrFail(Input::get('id'));
		$teaser->title = Input::get('title');
		$teaser->link_title = Input::get('link_title');
		$teaser_file = '';
		if (Input::hasFile('teaser_file')) {
			$new_image = true;
			$file = Input::file('teaser_file');
			$teaser_file = str_replace(' ', '_', strtolower($file->getClientOriginalName()));
			$teaser_file = filter_var($teaser_file, FILTER_SANITIZE_STRING);
			$teaser->teaser_file = $teaser_file;
    		$file->move('files/teasers/', $teaser_file);
    	}	
		$teaser->save();

        return Redirect::action('ExhibitionPagesController@index');
	}
	
	public function destroy($id) {
		Teaser::destroy($id);

		return Redirect::action('ExhibitionPagesController@index');
	}

	public function save() {
		// echo '<pre>'; print_r(Input::all()); exit;
		if(Input::has('teaser_id') && is_numeric(Input::get('teaser_id')) && intval(Input::get('teaser_id')) > 0) {
			$sp = Teaser::find(Input::get('teaser_id'));
			$sp->caption_de = Input::get('caption_de');
			$sp->caption_en = Input::get('caption_en');
			$sp->line_1_de = Input::get('line_1_de');
			$sp->line_1_en = Input::get('line_1_en');
			$sp->line_2_de = Input::get('line_2_de');
			$sp->line_2_en = Input::get('line_2_en');
			if (Input::hasFile('teaser_file')) {
				$file = Input::file('teaser_file');
				$teaser_file = strtolower($file->getClientOriginalName());
	    		$file->move('files/teasers/', $teaser_file);
	    		$sp->filename = $teaser_file;
	    	}	
			$sp->save();

		} else {
			$sp = new Teaser();
			$sp->caption_de = Input::get('caption_de');
			$sp->caption_en = Input::get('caption_en');
			$sp->line_1_de = Input::get('line_1_de');
			$sp->line_1_en = Input::get('line_1_en');
			$sp->line_2_de = Input::get('line_2_de');
			$sp->line_2_en = Input::get('line_2_en');
			if (Input::hasFile('teaser_file')) {
				$file = Input::file('teaser_file');
				$teaser_file = strtolower($file->getClientOriginalName());
	    		$file->move('files/teasers/', $teaser_file);
	    		$sp->filename = $teaser_file;
	    	}	
			$sp->save();

			$page = Page::find(Input::get('page_id'));
			$page->teaser()->save($sp);
		}

		return Redirect::action('ExhibitionPagesController@edit', ['id' => Input::get('page_id')]);
	}

	public function uploadTeaser() {
		if(Request::ajax()) {
			if (Input::hasFile('teaser_file')) {
				$file = Input::file('teaser_file');
				$img = strtolower($file->getClientOriginalName());
	    		$file->move('files/teasers/', $img);
	    		$preivew = '/files/teasers/' . $img;

				return Response::json(array('error' => false, 'preivew' => $preivew), 200);
			}
		}

		return Response::json(array('error' => true, 'message' => 'Error processing image'), 422);
	}

	public function getTeaser() {
		if(Input::has('id') && intval(Input::get('id')) > 0) {
			$item = Teaser::find(Input::get('id'));			
			$grp = DB::table('teaser_groups')->select('headline')->where('id', $item->teaser_group_id)->first();
			$item->headline = $grp->headline;
			return Response::json(array('error' => false, 'item' => $item), 200);
		}

		return Response::json(array('error' => true, 'message' => 'Error processing request'), 422);
	}

	public function deleteTeaser() {
		if (Input::has('id')) {
			Teaser::where('id', Input::get('id'))->delete();

			return Response::json(array('error' => false, 'msg' => 'deleted'), 200);
		}

		return Response::json(array('error' => true, 'message' => 'Error processing request'), 422);
	}

	public function store()
	{
		// echo '<pre>'; print_r(Input::all()); exit;
		$teaser = new Teaser;
		$teaser->title = Input::get('title');
		$teaser->link_title = Input::get('link_title');
		$teaser_file = '';
		if (Input::hasFile('teaser_file')) {
			$new_image = true;
			$file = Input::file('teaser_file');
			$teaser_file = str_replace(' ', '_', strtolower($file->getClientOriginalName()));
			$teaser_file = filter_var($teaser_file, FILTER_SANITIZE_STRING);
			$teaser->teaser_file = $teaser_file;
    		$file->move('files/teasers/', $teaser_file);
    	}	
		$teaser->save();

        return Redirect::action('ExhibitionPagesController@index');
	}
}
