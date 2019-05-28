<?php

class SponsorGroupsController extends BaseController {

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
		$sponsor_groups = SponsorGroup::get();	

		return View::make('pages.sponsor_groups.index', ['sponsor_groups' => $sponsor_groups]);
	}

	public function show()
	{
		// $events = Event::all();	

		return View::make('pages.sponsor_groups.index');//, ['events' => ['apples', 'oranges', 'mangoes'] ] ); // $events] );
	}

	public function create()
	{
		return View::make('pages.sponsor_groups.create');
	}

	public function edit($id)
	{
		$sponsor_group = SponsorGroup::findOrFail($id);

		return View::make('pages.sponsor_groups.edit', ['sponsor_group' => $sponsor_group]);
	}

	public function update()
	{
		$sponsor_group = SponsorGroup::findOrFail(Input::get('id'));
		$sponsor_group->title = Input::get('title');
		$sponsor_group->url = Input::get('url');
		$logo = '';
		if (Input::hasFile('logo')) {
			$new_image = true;
			$file = Input::file('logo');
			$logo = str_replace(' ', '_', strtolower($file->getClientOriginalName()));
			$logo = filter_var($logo, FILTER_SANITIZE_STRING);
			$sponsor_group->logo = $logo;
    		$file->move('files/pages/', $logo);
    	}	
		$sponsor_group->save();

        return Redirect::action('SponsorGroupsController@index');
	}
	
	public function destroy($id) {
		SponsorGroup::destroy($id);

		return Redirect::action('SponsorGroupsController@index');
	}
	
	public function deleteSponsorGroup() {
		if(Input::has('id')) {
			$sg = SponsorGroup::find(Input::get('id'));
			$sgs = SponsorGroup::where('page_id', $sg->page_id)->get();
			$hideGroups = (count($sgs) > 1) ? false : true;
			SponsorGroup::destroy(Input::get('id'));
			return Response::json(array('error' => false, 'hideGroups' => $hideGroups), 200);
		}

		return Response::json(array('error' => true, 'msg' => 'delete failed'), 422);
	}

	public function uploadLogo() {
		if(Request::ajax()) {
			if (Input::hasFile('logo')) {
				$file = Input::file('logo');
				$img = strtolower($file->getClientOriginalName());
	    		$file->move('files/sponsor_groups/', $img);
	    		$preivew = '/files/sponsor_groups/' . $img;

				return Response::json(array('error' => false, 'preivew' => $preivew), 200);
			}
		}

		return Response::json(array('error' => true, 'message' => 'Error processing image'), 422);
	}

	public function getSponsorGroup() {
		if(Input::has('id') && intval(Input::get('id')) > 0) {
			$grp = SponsorGroup::find(Input::get('id'));			

			return Response::json(array('error' => false, 'item' => $grp), 200);
		}

		return Response::json(array('error' => true, 'message' => 'Error processing request'), 422);
	}

	public function save() {
		if(Input::has('sponsor_grp_id') && is_numeric(Input::get('sponsor_grp_id')) && intval(Input::get('sponsor_grp_id')) > 0) {
			$grp = SponsorGroup::find(Input::get('sponsor_grp_id'));
			$grp->headline_de = Input::get('sponsor_group_de');
			$grp->headline_en = Input::get('sponsor_group_en');
			$grp->sort_order = Input::get('sort_order');
			$grp->save();

		} else {
			$grp = new SponsorGroup();
			$grp->headline_de = Input::get('sponsor_group_de');
			$grp->headline_en = Input::get('sponsor_group_en');
			$grp->page_id = Input::get('id');
			$grp->sort_order = Input::get('sort_order');
			$grp->save();

			$page = Page::find(Input::get('id'));
			$page->sponsor_groups()->save($grp);
		}

		return Redirect::action('PagesController@edit', ['menu_item_id' => Input::get('menu_item_id'), 'cs_id' => Input::get('cs_id'), 'id' => Input::get('id'),
			                    'action' => 'sponsor']);
	}

	public function store()
	{
		$sponsor_group = new SponsorGroup;
		$sponsor_group->title = Input::get('title');
		$sponsor_group->url = Input::get('url');
		$logo = '';
		if (Input::hasFile('logo')) {
			$new_image = true;
			$file = Input::file('logo');
			$logo = str_replace(' ', '_', strtolower($file->getClientOriginalName()));
			$logo = filter_var($logo, FILTER_SANITIZE_STRING);
			$sponsor_group->logo = $logo;
    		$file->move('files/pages/', $logo);
    	}	
		$sponsor_group->save();

        return Redirect::action('SponsorGroupsController@index');
	}
}
