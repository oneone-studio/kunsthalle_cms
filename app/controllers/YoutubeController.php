<?php

class YoutubeController extends BaseController {

	public function index()
	{
	}

	public function create()
	{
		return View::make('pages.menu_items.create');
	}

	public function store()
	{
		// echo '<pre>'; print_r(Input::all());exit;
		if(Input::has('youtube')) {
			$max_sort_order = 1;
			$page_sections = DB::select('select max(sort_order)+1 as max_sort_order from page_sections where page_id = '. Input::get('page_id'));
			if(is_array($page_sections) && count($page_sections)) {
				if($page_sections[0]->max_sort_order != null && is_numeric($page_sections[0]->max_sort_order)) {
					$max_sort_order = $page_sections[0]->max_sort_order;
				}
			}

			$youtube = new Youtube();
			$youtube->url = Input::get('url');
			$youtube->page_id = Input::get('page_id');
			$youtube->save();

			PageSection::insert(['page_id' => Input::get('page_id'), 'youtube_id' => $youtube->id, 'sort_order' => $max_sort_order]);
		}		

		return Redirect::action('PagesController@edit', ['menu_item_id' => Input::get('menu_item_id'), 'cs_id' => Input::get('cs_id'), 'id' => Input::get('page_id')]);
	}

	public function save() {
		// echo '<pre>'; print_r(Input::all()); //exit;
		$url = Input::get('url') . '&city=la';
		if(strpos($url, 'v=')) { $url = substr($url, strpos($url, 'v=')+2, strlen($url)); }
		// echo $url .'<br>';		
		if(strpos($url, '&')) { $url = substr($url, 0, strpos($url, '&')); }
		// echo $url;exit;
		if(Input::has('youtube_id') && intval(Input::get('youtube_id')) > 0) {
			$youtube = Youtube::find(Input::get('youtube_id'));
			$youtube->url = $url;
			$youtube->save();
		} else {
			$max_sort_order = 1;
			$page_sections = DB::select('select max(sort_order)+1 as max_sort_order from page_sections where page_id = '. Input::get('page_id'));
			if(is_array($page_sections) && count($page_sections)) {
				if($page_sections[0]->max_sort_order != null && is_numeric($page_sections[0]->max_sort_order)) {
					$max_sort_order = $page_sections[0]->max_sort_order;
				}
			}

			$youtube = new Youtube();
			$youtube->url = $url;
			$youtube->page_id = Input::get('page_id');
			$youtube->save();

			PageSection::insert(['page_id' => Input::get('page_id'), 'youtube_id' => $youtube->id, 'sort_order' => $max_sort_order]);
		}

		$params = [];
		if(Input::has('menu_item_id')) { $params[] = Input::get('menu_item_id'); }
		if(Input::has('cs_id')) { $params[] = Input::get('cs_id'); }
		if(Input::has('page_id')) { $params[] = Input::get('page_id'); }

		if(Input::has('menu_item_id')) {
			return Redirect::action('PagesController@edit', $params);
		} else {
			return Redirect::action('ExhibitionPagesController@edit', [Input::get('page_id')]);
		}
	}

	public function edit($id)
	{
		$menu_item = MenuItem::findOrFail($id);

		return View::make('pages.menu_items.edit', [ 'menu_item' => $menu_item ]);
	}

	public function update()
	{
		// echo '<pre>'; print_r(Input::all()); exit;
		if(Input::has('youtube_id')) {
			$youtube = Youtube::find(Input::get('youtube_id'));
			$youtube->url = Input::get('url');
			$youtube->save();
		}

		return Redirect::action('PagesController@edit', ['menu_item_id' => Input::get('menu_item_id'), 'cs_id' => Input::get('cs_id'), 'id' => Input::get('page_id')]);
	}
	
	public function destroy($id) {
		MenuItem::where('id', $id)->delete();

		return Redirect::action('MenuItemsController@index');
	}

	public function getYoutube() {
		if(Input::has('id')) {
			$youtube = Youtube::find(Input::get('page_id'));

			return Response::json(array('error' => false, 'youtube' => $youtube), 200);
		}

		return Response::json(array('error' => true, 'message' => 'Error processing request'), 422);
	}

	public function saveYoutube() {
		if(Input::has('id')) {
			$youtube = Youtube::find(Input::get('page_id'));
			$youtube->url = Input::get('url');
			$youtube->page_id = Input::get('page_id');
			$youtube->save();

			return Response::json(array('error' => false, 'youtube' => $youtube), 200);
		}

		return Response::json(array('error' => true, 'message' => 'Error processing request'), 422);
	}
}
