<?php

class SponsorsExbController extends BaseController {

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
		$sponsors = Sponsor::get();	

		return View::make('pages.sponsors.index', ['sponsors' => $sponsors]);
	}

	public function show()
	{
		// $events = Event::all();	

		return View::make('pages.sponsors.index');//, ['events' => ['apples', 'oranges', 'mangoes'] ] ); // $events] );
	}

	public function create()
	{
		return View::make('pages.sponsors.create');
	}

	public function edit($id)
	{
		$sponsor = Sponsor::findOrFail($id);

		return View::make('pages.sponsors.edit', ['sponsor' => $sponsor]);
	}

	public function update()
	{
		$sponsor = Sponsor::findOrFail(Input::get('id'));
		$sponsor->title = Input::get('title');
		$sponsor->url = Input::get('url');
		$logo = '';
		if (Input::hasFile('logo')) {
			$new_image = true;
			$file = Input::file('logo');
			$logo = str_replace(' ', '_', strtolower($file->getClientOriginalName()));
			$logo = filter_var($logo, FILTER_SANITIZE_STRING);
			$sponsor->logo = $logo;
    		$file->move('files/sponsors/', $logo);
    	}	
		$sponsor->save();

        return Redirect::action('ExhibitionPagesController@index');
	}
	
	public function destroy($id) {
		Sponsor::destroy($id);

		return Redirect::action('ExhibitionPagesController@index');
	}

	public function save() {
		// echo '<pre>'; print_r(Input::all()); exit;
		if(Input::has('sponsor_id') && is_numeric(Input::get('sponsor_id')) && intval(Input::get('sponsor_id')) > 0) {
			$sp = Sponsor::find(Input::get('sponsor_id'));
			$sp->url = Input::get('url');
			if (Input::hasFile('logo')) {
				$file = Input::file('logo');
				$logo = strtolower($file->getClientOriginalName());
	    		$file->move('files/sponsors/', $logo);
	    		$sp->logo = $logo;
	    	}	
			$sp->save();

		} else {
			$sp = new Sponsor();
			$sp->url = Input::get('url');
			if (Input::hasFile('logo')) {
				$file = Input::file('logo');
				$logo = strtolower($file->getClientOriginalName());
	    		$file->move('files/sponsors/', $logo);
	    		$sp->logo = $logo;
	    	}	
			$sp->save();

			$grp = SponsorGroup::find(Input::get('sponsor_grp_id'));
			$grp->sponsors()->save($sp);
		}

		return Redirect::action('ExhibitionPagesController@edit', ['id' => Input::get('page_id'), 'action'=>'new_sponsor']);
	}

	public function uploadLogo() {
		if(Request::ajax()) {
			if (Input::hasFile('logo')) {
				$file = Input::file('logo');
				$img = strtolower($file->getClientOriginalName());
	    		$file->move('files/sponsors/', $img);
	    		$preivew = '/files/sponsors/' . $img;

				return Response::json(array('error' => false, 'preivew' => $preivew), 200);
			}
		}

		return Response::json(array('error' => true, 'message' => 'Error processing image'), 422);
	}

	public function getSponsor() {
		if(Input::has('id') && intval(Input::get('id')) > 0) {
			$item = Sponsor::find(Input::get('id'));			
			$grp = DB::table('sponsor_groups')->select('headline')->where('id', $item->sponsor_group_id)->first();
			$item->headline = $grp->headline;
			return Response::json(array('error' => false, 'item' => $item), 200);
		}

		return Response::json(array('error' => true, 'message' => 'Error processing request'), 422);
	}

	public function deleteSponsor() {
		if (Input::has('id')) {
			Sponsor::where('id', Input::get('id'))->delete();

			return Response::json(array('error' => false, 'msg' => 'deleted'), 200);
		}

		return Response::json(array('error' => true, 'message' => 'Error processing request'), 422);
	}

	public function store()
	{
		// echo '<pre>'; print_r(Input::all()); exit;
		$sponsor = new Sponsor;
		$sponsor->title = Input::get('title');
		$sponsor->url = Input::get('url');
		$logo = '';
		if (Input::hasFile('logo')) {
			$new_image = true;
			$file = Input::file('logo');
			$logo = str_replace(' ', '_', strtolower($file->getClientOriginalName()));
			$logo = filter_var($logo, FILTER_SANITIZE_STRING);
			$sponsor->logo = $logo;
    		$file->move('files/sponsors/', $logo);
    	}	
		$sponsor->save();

        return Redirect::action('ExhibitionPagesController@index');
	}
}
