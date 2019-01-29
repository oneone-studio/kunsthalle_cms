<?php

class ImageGridController extends BaseController {

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
		if(Input::has('page_id')) {
			$max_sort_order = 1;
			$page_sections = DB::select('select max(sort_order)+1 as max_sort_order from page_sections where page_id = '. Input::get('page_id'));
			if(is_array($page_sections) && count($page_sections)) {
				if($page_sections[0]->max_sort_order != null && is_numeric($page_sections[0]->max_sort_order)) {
					$max_sort_order = $page_sections[0]->max_sort_order;
				}
			}

			$grid = new ImageGrid();
			$grid->page_id = Input::get('page_id');
			$grid->save();

			PageSection::insert(['page_id' => Input::get('page_id'), 'image_grid_id' => $grid->id, 'sort_order' => $max_sort_order]);
		}		

		return Redirect::action('PagesController@edit', ['menu_item_id' => Input::get('menu_item_id'), 'cs_id' => Input::get('cs_id'), 
								'id' => Input::get('page_id'), 'action' => 'image_grid']);
	}

	public function save() {
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

		return Redirect::action('PagesController@edit', ['menu_item_id' => Input::get('menu_item_id'), 'cs_id' => Input::get('cs_id'), 'id' => Input::get('id')]);
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
		$grid = ImageGrid::findOrFail($id);

		return View::make('pages.menu_items.edit', [ 'image_grid' => $grid ]);
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

		return Redirect::action('PagesController@edit', ['menu_item_id' => Input::get('menu_item_id'), 'cs_id' => Input::get('cs_id'), 'id' => Input::get('id')]);
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
