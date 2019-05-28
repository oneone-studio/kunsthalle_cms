<?php

class ExhibitionClustersController extends BaseController {

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
		$clusters = ExhibitionCluster::with('exhibitions')->get();	

		return View::make('pages.exhibition_clusters.index', ['clusters' => $clusters]);
	}

	public function show()
	{
		// $exhibitions = Exhibition::all();
		return View::make('pages.exhibition_clusters.index');//, ['exhibitions' => ['apples', 'oranges', 'mangoes'] ] ); // $exhibitions] );
	}

	public function create()
	{
		$exhibitions = Exhibition::all();
		$tags = Tag::all();

		return View::make('pages.exhibition_clusters.create', ['exhibitions' => $exhibitions, 'tags' => $tags]);
	}

	public function edit($id)
	{
		$cluster = ExhibitionCluster::with('exhibitions')->findOrFail($id);
		$exhibitions = Exhibition::all();
		$tags = Tag::all();

		return View::make('pages.exhibition_clusters.edit', [ 'cluster' => $cluster, 'exhibitions' => $exhibitions, 'tags' => $tags ]);
	}

	public function update()
	{

		$clstr = ExhibitionCluster::with('exhibitions')->with('tags')->findOrFail(Input::get('id'));

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
		$exhibitions = Input::get('exhibitions');
		if(is_array($exhibitions)) {
			$clstr->exhibitions()->sync($exhibitions);
		}

		$clstr->save();

        return Redirect::action('ExhibitionClustersController@index');
	}
	
	public function destroy($id) {
		ExhibitionCluster::destroy($id);

		return Redirect::action('ExhibitionClustersController@index');
	}

	public function store()
	{
		$input = Input::all();

		$ex = new ExhibitionCluster;

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

		$ex->save();

		$exhibitions = Input::get('exhibitions');		
		if(is_array($exhibitions)) {
			$ex->exhibitions()->sync($exhibitions);
		}
		$tags = Input::get('tags');
		if(is_array($tags)) {
			$ex->tags()->sync($tags);
		}

		/**/
        // $validation = Validator::make($input, User::$rules);
        // if ($validation->passes())
        // {
            // Exhibition::create($input);

        return Redirect::action('ExhibitionClustersController@index');
        // }

        /*    
        return Redirect::route('exhibitions.create')
            ->withInput()
            // ->withErrors($validation)
            ->with('message', 'There were validation errors.');    
        /**/    
	}

	public function test() {
		return View::make('pages.exhibition_clusters.test');
	}


}
