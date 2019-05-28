<?php

class H2Controller extends BaseController {

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
		if(Input::has('h2')) {
			$max_sort_order = 1;
			$page_sections = DB::select('select max(sort_order)+1 as max_sort_order from page_sections where page_id = '. Input::get('id'));
			if(is_array($page_sections) && count($page_sections)) {
				if($page_sections[0]->max_sort_order != null && is_numeric($page_sections[0]->max_sort_order)) {
					$max_sort_order = $page_sections[0]->max_sort_order;
				}
			}

			$h2 = new H2();
			$h2->headline_de = Input::get('h2_de');
			$h2->headline_en = Input::get('h2_en');
			$h2->page_id = Input::get('page_id');
			$h2->save();

			PageSection::insert(['page_id' => Input::get('id'), 'h2_id' => $h2->id, 'sort_order' => $max_sort_order]);
		}		

		return Redirect::action('PagesController@edit', ['menu_item_id' => Input::get('menu_item_id'), 'cs_id' => Input::get('cs_id'), 'id' => Input::get('id')]);
	}

	public function save() {
		if(Input::has('h2_id') && intval(Input::get('h2_id')) > 0) {
			$h2 = H2::find(Input::get('h2_id'));
			$h2->headline_de = Input::get('h2_de');
			$h2->headline_en = Input::get('h2_en');
			$h2->save();
		} else {
			$max_sort_order = 1;
			$page_sections = DB::select('select max(sort_order)+1 as max_sort_order from page_sections where page_id = '. Input::get('id'));
			if(is_array($page_sections) && count($page_sections)) {
				if($page_sections[0]->max_sort_order != null && is_numeric($page_sections[0]->max_sort_order)) {
					$max_sort_order = $page_sections[0]->max_sort_order;
				}
			}

			$h2 = new H2();
			$h2->headline_de = Input::get('h2_de');
			$h2->headline_en = Input::get('h2_en');
			$h2->page_id = Input::get('page_id');
			$h2->save();

			PageSection::insert(['page_id' => Input::get('id'), 'h2_id' => $h2->id, 'sort_order' => $max_sort_order]);
		}

		return Redirect::action('PagesController@edit', ['menu_item_id' => Input::get('menu_item_id'), 'cs_id' => Input::get('cs_id'), 'id' => Input::get('id')]);
	}

	public function edit($id)
	{
		$menu_item = MenuItem::findOrFail($id);

		return View::make('pages.menu_items.edit', [ 'menu_item' => $menu_item ]);
	}

	public function update()
	{
		// echo '<pre>'; print_r(Input::all()); exit;
		if(Input::has('h2_id')) {
			$h2 = H2::find(Input::get('h2_id'));
			$h2->headline_de = Input::get('h2_de');
			$h2->headline_en = Input::get('h2_en');
			$h2->save();
		}

		return Redirect::action('PagesController@edit', ['menu_item_id' => Input::get('menu_item_id'), 'cs_id' => Input::get('cs_id'), 'id' => Input::get('id')]);
	}
	
	public function destroy($id) {
		MenuItem::where('id', $id)->delete();

		return Redirect::action('MenuItemsController@index');
	}

	public function getH2() {
		if(Input::has('id')) {
			$h2 = H2::find(Input::get('id'));

			return Response::json(array('error' => false, 'h2' => $h2), 200);
		}

		return Response::json(array('error' => true, 'message' => 'Error processing request'), 422);
	}

	public function saveH2() {
		if(Input::has('id')) {
			$h2 = H2::find(Input::get('id'));
			$h2->headline_de = Input::get('h2_de');
			$h2->headline_en = Input::get('h2_en');
			$h2->page_id = Input::get('page_id');
			$h2->save();

			return Response::json(array('error' => false, 'h2' => $h2), 200);
		}

		return Response::json(array('error' => true, 'message' => 'Error processing request'), 422);
	}
}
