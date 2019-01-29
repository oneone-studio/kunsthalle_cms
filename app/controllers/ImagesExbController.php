<?php

class ImagesExbController extends BaseController {

	public function index()
	{
	}

	public function create()
	{
		return View::make('pages.menu_items.create');
	}

	public function store()
	{
		if(Input::has('image')) {
			$max_sort_order = 1;
			$page_sections = DB::select('select max(sort_order)+1 as max_sort_order from page_sections where page_id = '. Input::get('id'));
			if(is_array($page_sections) && count($page_sections)) {
				if($page_sections[0]->max_sort_order != null && is_numeric($page_sections[0]->max_sort_order)) {
					$max_sort_order = $page_sections[0]->max_sort_order;
				}
			}

			$image = new Image();
			$image->caption_de = Input::get('image_caption_de');
			$image->caption_en = Input::get('image_caption_en');
			$image->page_id = Input::get('page_id');
			$image->save();

			PageSection::insert(['page_id' => Input::get('id'), 'image_id' => $image->id, 'sort_order' => $max_sort_order]);
		}		

		return Redirect::action('ExhibitionPagesController@edit', ['id' => Input::get('id')]);
	}

	public function save() {
		// echo '<pre>'; print_r(Input::all());exit;
		if(Input::has('image_id') && intval(Input::get('image_id')) > 0) {

			$image = Image::find(Input::get('image_id'));
			if (Input::hasFile('image')) {
				$file = Input::file('image');
	    		$file->move('files/image/', $file->getClientOriginalName());
	    		$image->filename = $file->getClientOriginalName();
	    	}	
			$image->caption_de = Input::get('image_caption_de');
			$image->caption_en = Input::get('image_caption_en');
			$image->save();

		} else {
			$max_sort_order = 1;
			$page_sections = DB::select('select max(sort_order)+1 as max_sort_order from page_sections where page_id = '. Input::get('id'));
			if(is_array($page_sections) && count($page_sections)) {
				if($page_sections[0]->max_sort_order != null && is_numeric($page_sections[0]->max_sort_order)) {
					$max_sort_order = $page_sections[0]->max_sort_order;
				}
			}

			if (Input::hasFile('image')) {

				$file = Input::file('image');
	    		$file->move('files/image/', $file->getClientOriginalName());

	    		$image = new Image();
	    		$image->filename = $file->getClientOriginalName();
	    		$image->path = '/image/';
	    		$image->page_id = Input::get('id');
	    		$image->caption_de = Input::get('image_caption_de');
	    		$image->caption_en = Input::get('image_caption_en');
	    		$image->save();

				PageSection::insert(['page_id' => Input::get('id'), 'image_id' => $image->id, 'sort_order' => $max_sort_order]);
			}
		}

		return Redirect::action('ExhibitionPagesController@edit', ['id' => Input::get('id')]);
	}

	public function uploadImage() {
		if(Request::ajax()) {
			if (Input::hasFile('image')) {
				$file = Input::file('image');
				$img = strtolower($file->getClientOriginalName());
	    		$file->move('files/image/', $img);
	    		$preivew = '/files/image/' . $img;

				return Response::json(array('error' => false, 'preivew' => $preivew), 200);
			}
		}

		return Response::json(array('error' => true, 'message' => 'Error processing image'), 422);
	}

	public function edit($id)
	{
		$menu_item = MenuItem::findOrFail($id);

		return View::make('pages.menu_items.edit', [ 'menu_item' => $menu_item ]);
	}

	public function update()
	{
		// echo '<pre>'; print_r(Input::all()); exit;
		if(Input::has('image_id')) {
			$image = Image::find(Input::get('image_id'));
			$image->headline_de = Input::get('image_de');
			$image->headline_en = Input::get('image_en');
			$image->save();
		}

		return Redirect::action('ExhibitionPagesController@edit', ['id' => Input::get('id')]);
	}
	
	public function destroy($id) {
		MenuItem::where('id', $id)->delete();

		return Redirect::action('MenuItemsController@index');
	}

	public function getImage() {
		if(Input::has('id')) {
			$image = Image::find(Input::get('id'));

			return Response::json(array('error' => false, 'image' => $image), 200);
		}

		return Response::json(array('error' => true, 'message' => 'Error processing request'), 422);
	}

	public function saveImage() {
		if(Input::has('id')) {
			$image = Image::find(Input::get('id'));
			$image->headline_de = Input::get('image_de');
			$image->headline_en = Input::get('image_en');
			$image->page_id = Input::get('page_id');
			$image->save();

			return Response::json(array('error' => false, 'image' => $image), 200);
		}

		return Response::json(array('error' => true, 'message' => 'Error processing request'), 422);
	}
}
