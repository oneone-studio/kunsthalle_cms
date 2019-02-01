<?php

class H2textExbController extends BaseController {

	public function index()
	{
	}
	public function store()
	{
		// echo '<pre>'; print_r(Input::all());exit;
		if(Input::has('h2text')) {
			$max_sort_order = 1;
			$page_sections = DB::select('select max(sort_order)+1 as max_sort_order from page_sections where page_id = '. Input::get('id'));
			if(is_array($page_sections) && count($page_sections)) {
				if($page_sections[0]->max_sort_order != null && is_numeric($page_sections[0]->max_sort_order)) {
					$max_sort_order = $page_sections[0]->max_sort_order;
				}
			}

			$h2text = new H2text();
			$h2text->headline_de = Input::get('h2_de');
			$h2text->headline_en = Input::get('h2_en');
			$h2text->intro_de = Input::get('intro_de');
			$h2text->intro_en = Input::get('intro_en');
			$h2text->page_id = Input::get('page_id');
			$h2text->save();

			PageSection::insert(['page_id' => Input::get('id'), 'h2_text_id' => $h2text->id, 'sort_order' => $max_sort_order]);
		}		

		return Redirect::action('ExhibitionPagesController@edit', ['id' => Input::get('id')]);
	}

	public function save() {
		// echo '<pre>'; print_r(Input::all());exit;
		if(Input::has('h2text_id') && intval(Input::get('h2text_id')) > 0) {
			$h2text = H2text::find(Input::get('h2text_id'));
			$h2text->headline_de = Input::get('h2_de');
			$h2text->headline_en = Input::get('h2_en');
			$h2text->intro_de = Input::get('intro_de');
			$h2text->intro_en = Input::get('intro_en');
			$h2text->anchor_title_de = Input::get('anchor_title_de');
			$h2text->anchor_title_en = Input::get('anchor_title_en');
			$h2text->save();
		} else {
			$max_sort_order = 1;
			$page_sections = DB::select('select max(sort_order)+1 as max_sort_order from page_sections where page_id = '. Input::get('id'));
			if(is_array($page_sections) && count($page_sections)) {
				if($page_sections[0]->max_sort_order != null && is_numeric($page_sections[0]->max_sort_order)) {
					$max_sort_order = $page_sections[0]->max_sort_order;
				}
			}

			$h2text = new H2text();
			$h2text->headline_de = Input::get('h2_de');
			$h2text->headline_en = Input::get('h2_en');
			$h2text->intro_de = Input::get('intro_de');
			$h2text->intro_en = Input::get('intro_en');
			$h2text->anchor_title_de = Input::get('anchor_title_de');
			$h2text->anchor_title_en = Input::get('anchor_title_en');
			$h2text->page_id = Input::get('id');
			$h2text->save();

			PageSection::insert(['page_id' => Input::get('id'), 'h2_text_id' => $h2text->id, 'sort_order' => $max_sort_order]);
		}
	
		return Redirect::action('ExhibitionPagesController@edit', ['id' => Input::get('id')]);
	}
		
	public function edit($id)
	{
		$menu_item = MenuItem::findOrFail($id);

		return View::make('pages.menu_items.edit', [ 'menu_item' => $menu_item ]);
	}

	public function update()
	{
		if(Input::has('h2text_id')) {
			$h2text = H2text::find(Input::get('h2text_id'));
			$h2text->headline_de = Input::get('h2_de');
			$h2text->headline_en = Input::get('h2_en');
			$h2text->intro_de = Input::get('intro_de');
			$h2text->intro_en = Input::get('intro_en');
			$h2text->save();
		}

		return Redirect::action('ExhibitionPagesController@edit', ['id' => Input::get('id')]);
	}
	
	public function destroy($id) {
		MenuItem::where('id', $id)->delete();

		return Redirect::action('MenuItemsController@index');
	}

	public function getH2text() {
		if(Input::has('id')) {
			$h2text = H2text::find(Input::get('id'));

			return Response::json(array('error' => false, 'item' => $h2text), 200);
		}

		return Response::json(array('error' => true, 'message' => 'Error processing request'), 422);
	}

	public function saveH2text() {
		if(Input::has('h2text_id')) {
			$h2text = H2text::find(Input::get('h2text_id'));
			$h2text->headline_de = Input::get('h2_de');
			$h2text->headline_en = Input::get('h2_en');
			$h2text->intro_de = Input::get('intro_de');
			$h2text->intro_en = Input::get('intro_en');
			$h2text->page_id = Input::get('page_id');
			$h2text->save();
		
			return Response::json(array('error' => false, 'h2text' => $h2text), 200);
		}

		return Response::json(array('error' => true, 'message' => 'Error processing request'), 422);
	}
}
