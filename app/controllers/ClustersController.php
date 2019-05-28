<?php

class ClustersController extends BaseController {

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
		if(!AuthHelper::authCheck('Clusters list')) { return Redirect::to('http://www.google.com'); }
		$clusters = Cluster::with('k_events')->get();	

		return View::make('pages.clusters.index', ['clusters' => $clusters]);
	}

	public function show()
	{
		// $events = Event::all();	

		return View::make('pages.clusters.index');//, ['events' => ['apples', 'oranges', 'mangoes'] ] ); // $events] );
	}

	public function create()
	{
		$k_events = KEvent::all();
		$tags = Tag::all();

		return View::make('pages.clusters.create', ['k_events' => $k_events, 'tags' => $tags]);
	}

	public function edit($id)
	{
		$cluster = Cluster::with(['k_events', 'kEventCost'])->findOrFail($id);
		$k_events = KEvent::all();
		$tags = Tag::all();

		if(!isset($cluster->kEventCost)) {
			$cost = new kEventCost();
			$cost->cluster_id = $cluster->id;
			$cost->regular_adult_price = 0;
			$cost->regular_child_price = 0;
			$cost->member_adult_price = 0;
			$cost->member_child_price = 0;
			$cost->reduced_price = 0;
			$cost->sibling_child_price = 0;
			$cost->sibling_member_price = 0;
			$cost->inclusive_material = 0;
			$cost->entry_fee = 0;
			$cost->save();

			$cluster->kEventCost()->save($cost);
			$cluster->save();
		}

		return View::make('pages.clusters.edit', [ 'cluster' => $cluster, 'k_events' => $k_events, 'tags' => $tags ]);
	}

	public function update()
	{
		// echo '<pre>'; print_r(Input::all());exit;
		$clstr = Cluster::with('k_events')->with('tags')->findOrFail(Input::get('id'));

		$clstr->title_de = Input::get('title_de');
		$clstr->title_en = Input::get('title_en');
		$clstr->subtitle_de = Input::get('subtitle_de');
		$clstr->subtitle_en = Input::get('subtitle_en');
		$clstr->remarks_de = Input::get('remarks_de');
		$clstr->remarks_en = Input::get('remarks_en');
		$clstr->cluster_type = Input::get('cluster_type');
		$clstr->package = Input::has('package') ? 1 : 0;
		// $clstr->cost_3_month_in_advance_adult = Input::get('cost_3_month_in_advance_adult');
		// $clstr->cost_3_month_in_advance_child = Input::get('cost_3_month_in_advance_child');
		// $clstr->cost_3_month_in_advance_members = Input::get('cost_3_month_in_advance_members');
		// $clstr->cost_all_at_once_adult = Input::get('cost_all_at_once_adult');
		// $clstr->cost_all_at_once_child = Input::get('cost_all_at_once_child');
		// $clstr->cost_all_at_once_members = Input::get('cost_all_at_once_members');


		if($clstr->kEventCost) { // is_numeric($evt->kEventCost->id) && $evt->kEventCost->id > 0) {
			$cost = $clstr->kEventCost; // KEventCost::find($evt->kEventCost->id);
		}	
		if(!isset($cost)) {
			$cost = new kEventCost();
			$cost->k_event_id = $evt->id;
		}

		if(strlen(trim(Input::get('regular_adult_price'))) > 0 && floatval(Input::get('regular_adult_price')) >= 0) {
			$regular_adult_price = str_replace(',', '.', Input::get('regular_adult_price'));
			// $regular_adult_price = str_pad(substr($regular_adult_price, 0, strpos($regular_adult_price, '.')), 2, '0', STR_PAD_LEFT); //. '.00';
			if(strpos($regular_adult_price, '.')) { $regular_adult_price = substr($regular_adult_price, 0, strpos($regular_adult_price, '.')); }
		} else {
			$regular_adult_price = '';
		}

		if(strlen(trim(Input::get('regular_child_price'))) > 0 && floatval(Input::get('regular_child_price')) >= 0) {
			$regular_child_price = str_replace(',', '.', Input::get('regular_child_price'));
			// $regular_child_price = str_pad(substr($regular_child_price, 0, strpos($regular_child_price, '.')), 2, '0', STR_PAD_LEFT); //. '.00';
			if(strpos($regular_child_price, '.')) { $regular_child_price = substr($regular_child_price, 0, strpos($regular_child_price, '.')); }
		} else {
			$regular_child_price = '';
		}

		if(strlen(trim(Input::get('member_adult_price'))) > 0 && floatval(Input::get('member_adult_price')) >= 0) {
			$member_adult_price = str_replace(',', '.', Input::get('member_adult_price'));
			// $member_adult_price = str_pad(substr($member_adult_price, 0, strpos($member_adult_price, '.')), 2, '0', STR_PAD_LEFT); //. '.00';
			if(strpos($member_adult_price, '.')) { $member_adult_price = substr($member_adult_price, 0, strpos($member_adult_price, '.')); }
		} else {
			$member_adult_price = '';
		}

		if(strlen(trim(Input::get('member_child_price'))) > 0 && floatval(Input::get('member_child_price')) >= 0) {
			$member_child_price = str_replace(',', '.', Input::get('member_child_price'));
			// $member_child_price = str_pad(substr($member_child_price, 0, strpos($member_child_price, '.')), 2, '0', STR_PAD_LEFT); //. '.00';
			if(strpos($member_child_price, '.')) { $member_child_price = substr($member_child_price, 0, strpos($member_child_price, '.')); }
		} else {
			$member_child_price = '';
		}

		if(strlen(trim(Input::get('sibling_child_price'))) > 0 && floatval(Input::get('sibling_child_price')) >= 0) {
			$sibling_child_price = str_replace(',', '.', Input::get('sibling_child_price'));
			// $sibling_child_price = str_pad(substr($sibling_child_price, 0, strpos($sibling_child_price, '.')), 2, '0', STR_PAD_LEFT); //. '.00';
			if(strpos($sibling_child_price, '.')) { $sibling_child_price = substr($sibling_child_price, 0, strpos($sibling_child_price, '.')); }
		} else {
			$sibling_child_price = '';
		}

		if(strlen(trim(Input::get('sibling_member_price'))) > 0 && floatval(Input::get('sibling_member_price')) >= 0) {
			$sibling_member_price = str_replace(',', '.', Input::get('sibling_member_price'));
			// $sibling_member_price = str_pad(substr($sibling_member_price, 0, strpos($sibling_member_price, '.')), 2, '0', STR_PAD_LEFT); //. '.00';
			if(strpos($sibling_member_price, '.')) { $sibling_member_price = substr($sibling_member_price, 0, strpos($sibling_member_price, '.')); }
		} else {
			$sibling_member_price = '';
		}

		if(strlen(trim(Input::get('reduced_price'))) > 0 && floatval(Input::get('reduced_price')) >= 0) {
			$reduced_price = str_replace(',', '.', Input::get('reduced_price'));
			// $sibling_member_price = str_pad(substr($sibling_member_price, 0, strpos($sibling_member_price, '.')), 2, '0', STR_PAD_LEFT); //. '.00';
			if(strpos($reduced_price, '.')) { $reduced_price = substr($reduced_price, 0, strpos($reduced_price, '.')); }
		} else {
			$reduced_price = '';
		}

		// echo $regular_adult_price.'<br>'.$regular_child_price.'<br>'.$member_adult_price.'<br>'.$member_child_price.'<br>'.$sibling_member_price.'<br>'.$sibling_child_price;exit;
		$cost->regular_adult_price = $regular_adult_price;
		$cost->regular_child_price = $regular_child_price;
		$cost->member_adult_price = $member_adult_price;
		$cost->member_child_price = $member_child_price;
		$cost->sibling_child_price = $sibling_child_price;
		$cost->sibling_member_price = $sibling_member_price;
		$cost->reduced_price = $reduced_price;

		$cost->save();			
		$clstr->kEventCost()->save($cost);


		$tags = Input::get('tags');
		if(is_array($tags)) {
			$clstr->tags()->sync($tags);
		}
		$kevents = Input::get('kevents');
		if(is_array($kevents)) {
			$clstr->k_events()->sync($kevents);
		}

		$clstr->save();

        return Redirect::action('ClustersController@index');
	}
	
	public function destroy($id) {
		Cluster::destroy($id);

		return Redirect::action('ClustersController@index');
	}

	public function store()
	{
		$input = Input::all();

		$clstr = new Cluster;

		$clstr->title_de = Input::get('title_de');
		$clstr->title_en = Input::get('title_en');
		$clstr->subtitle_de = Input::get('subtitle_de');
		$clstr->subtitle_en = Input::get('subtitle_en');
		$clstr->remarks_de = Input::get('remarks_de');
		$clstr->remarks_en = Input::get('remarks_en');
		$clstr->cluster_type = Input::get('cluster_type');
		$clstr->cost_3_month_in_advance_adult = Input::get('cost_3_month_in_advance_adult');
		$clstr->cost_3_month_in_advance_child = Input::get('cost_3_month_in_advance_child');
		$clstr->cost_3_month_in_advance_members = Input::get('cost_3_month_in_advance_members');
		$clstr->cost_all_at_once_adult = Input::get('cost_all_at_once_adult');
		$clstr->cost_all_at_once_child = Input::get('cost_all_at_once_child');
		$clstr->cost_all_at_once_members = Input::get('cost_all_at_once_members');
		// $ex-> = Input::get('');
		$clstr->save();

		$kevents = Input::get('kevents');
		if(is_array($kevents)) {
			$clstr->k_events()->sync($kevents);
		}
		$tags = Input::get('tags');
		if(is_array($tags)) {
			$clstr->tags()->sync($tags);
		}

		/**/
        // $validation = Validator::make($input, User::$rules);
        // if ($validation->passes())
        // {
            // Event::create($input);

            return Redirect::action('ClustersController@index');
        // }

        /*    
        return Redirect::route('events.create')
            ->withInput()
            // ->withErrors($validation)
            ->with('message', 'There were validation errors.');    
        /**/    
	}

	public function test() {
		return View::make('pages.clusters.test');
	}


}
