<?php

class EventClustersController extends BaseController {

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
		$clusters = EventCluster::with('k_events')->get();	

		return View::make('pages.event_clusters.index', ['clusters' => $clusters]);
	}

	public function show()
	{
		// $events = Event::all();	

		return View::make('pages.event_clusters.index');//, ['events' => ['apples', 'oranges', 'mangoes'] ] ); // $events] );
	}

	public function create()
	{
		$k_events = KEvent::all();
		$tags = Tag::all();

		return View::make('pages.event_clusters.create', ['k_events' => $k_events, 'tags' => $tags]);
	}

	public function edit($id)
	{
		$cluster = EventCluster::with('k_events')->findOrFail($id);
		$k_events = KEvent::all();
		$tags = Tag::all();

		return View::make('pages.event_clusters.edit', [ 'cluster' => $cluster, 'k_events' => $k_events, 'tags' => $tags ]);
	}

	public function update()
	{

		$clstr = EventCluster::with('k_events')->with('tags')->findOrFail(Input::get('id'));

		$clstr->title_de = Input::get('title_de');
		$clstr->title_en = Input::get('title_en');
		$clstr->subtitle_de = Input::get('subtitle_de');
		$clstr->subtitle_en = Input::get('subtitle_en');
		$clstr->remarks_de = Input::get('remarks_de');
		$clstr->remarks_en = Input::get('remarks_en');
		$clstr->cost_3_month_in_advance_adult = Input::get('cost_3_month_in_advance_adult');
		$clstr->cost_3_month_in_advance_child = Input::get('cost_3_month_in_advance_child');
		$clstr->cost_3_month_in_advance_members = Input::get('cost_3_month_in_advance_members');
		$clstr->cost_all_at_once_adult = Input::get('cost_all_at_once_adult');
		$clstr->cost_all_at_once_child = Input::get('cost_all_at_once_child');
		$clstr->cost_all_at_once_members = Input::get('cost_all_at_once_members');

		$tags = Input::get('tags');
		if(is_array($tags)) {
			$clstr->tags()->sync($tags);
		}
		$kevents = Input::get('kevents');
		if(is_array($kevents)) {
			$clstr->k_events()->sync($kevents);
		}

		$clstr->save();

        return Redirect::action('EventClustersController@index');
	}
	
	public function destroy($id) {
		KEvent::destroy($id);

		return Redirect::action('EventClustersController@index');
	}

	public function store()
	{
		$input = Input::all();

		$ex = new EventCluster;

		$ex->title_de = Input::get('title_de');
		$ex->title_en = Input::get('title_en');
		$ex->subtitle_de = Input::get('subtitle_de');
		$ex->subtitle_en = Input::get('subtitle_en');
		$ex->remarks_de = Input::get('remarks_de');
		$ex->remarks_en = Input::get('remarks_en');
		$ex->cost_3_month_in_advance_adult = Input::get('cost_3_month_in_advance_adult');
		$ex->cost_3_month_in_advance_child = Input::get('cost_3_month_in_advance_child');
		$ex->cost_3_month_in_advance_members = Input::get('cost_3_month_in_advance_members');
		$ex->cost_all_at_once_adult = Input::get('cost_all_at_once_adult');
		$ex->cost_all_at_once_child = Input::get('cost_all_at_once_child');
		$ex->cost_all_at_once_members = Input::get('cost_all_at_once_members');
		// $ex-> = Input::get('');
		$ex->save();

		$kevents = Input::get('kevents');
		if(is_array($kevents)) {
			$ex->k_events()->sync($kevents);
		}
		$tags = Input::get('tags');
		if(is_array($tags)) {
			$ex->tags()->sync($tags);
		}

		/**/
        // $validation = Validator::make($input, User::$rules);
        // if ($validation->passes())
        // {
            // Event::create($input);

            return Redirect::action('EventClustersController@index');
        // }

        /*    
        return Redirect::route('events.create')
            ->withInput()
            // ->withErrors($validation)
            ->with('message', 'There were validation errors.');    
        /**/    
	}

	public function test() {
		return View::make('pages.event_clusters.test');
	}


}
