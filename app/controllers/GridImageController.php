<?php

class GridImageController extends BaseController {

	public function index()
	{
	}

	public function create()
	{
		return View::make('pages.menu_items.create');
	}

	public function store()
	{
		// if(Input::has('grid_image')) {
		// 	$max_sort_order = 1;
		// 	$page_sections = DB::select('select max(sort_order)+1 as max_sort_order from page_sections where page_id = '. Input::get('id'));
		// 	if(is_array($page_sections) && count($page_sections)) {
		// 		if($page_sections[0]->max_sort_order != null && is_numeric($page_sections[0]->max_sort_order)) {
		// 			$max_sort_order = $page_sections[0]->max_sort_order;
		// 		}
		// 	}

		// 	$image = new Image();
		// 	$image->caption_de = Input::get('image_caption_de');
		// 	$image->caption_en = Input::get('image_caption_en');
		// 	$image->page_id = Input::get('page_id');
		// 	$image->save();

		// 	PageSection::insert(['page_id' => Input::get('id'), 'image_id' => $image->id, 'sort_order' => $max_sort_order]);
		// }		

		// return Redirect::action('PagesController@edit', ['menu_item_id' => Input::get('menu_item_id'), 'cs_id' => Input::get('cs_id'), 'id' => Input::get('id')]);
	}

	public function save() {
		// echo '<pre>'; print_r(Input::all());exit;
		$f = fopen('cms.log', 'w+');
		fwrite($f, "save() [".date('Y-m-d H:i')."]\n\n". print_r(Input::all(), true));
		$save_image = false;
		$filename = '';
		if(Input::has('image_grid_id')) {
			if (Input::hasFile('grid_image')) {
				$file = Input::file('grid_image');
	    		$filename = $file->getClientOriginalName();
				$filename = preg_replace('/[^A-Za-z0-9\-.]/', '', $filename);
	    		$file->move('files/grid_image/', $filename);
	    		$save_image = true;
	    	}	
			fwrite($f, "\n\nFile: ". $filename);
			if(Input::has('grid_image_id') && intval(Input::get('grid_image_id')) > 0) {
				$image = GridImage::find(Input::get('grid_image_id'));
				if ($save_image) {
		    		$image->filename = $filename;
		    	}	
				$image->url = Input::get('url');
				$image->save();

			} else {
				$max_sort_order = 1;
				$page_sections = DB::select('select max(sort_order)+1 as max_sort_order from page_sections where page_id = '. Input::get('page_id'));
				if(is_array($page_sections) && count($page_sections)) {
					if($page_sections[0]->max_sort_order != null && is_numeric($page_sections[0]->max_sort_order)) {
						$max_sort_order = $page_sections[0]->max_sort_order;
					}
				}
	    		$image = new GridImage();
				if ($save_image) {
		    		$image->filename = $filename;
		    	}	
	    		$image->path = '/files/grid_image/';
	    		$image->image_grid_id = Input::get('image_grid_id');
				$image->url = Input::get('url');
	    		$image->save();
			}
			$grid = ImageGrid::with(['grid_images'])->find(Input::get('image_grid_id'));
			$images = [];
			if($grid) { $images = $grid->grid_images; }

			return Response::json(array('error' => false, 'images' => $images), 200);
		}

		return Response::json(array('error' => false, 'msg' => 'Error'), 400);
	}

	public function uploadImage() {
		$f = fopen('test.log', 'w+');
		fwrite($f, print_r(Input::all(), true));
		if (Input::hasFile('grid_image')) {
			$file = Input::file('grid_image');
			$img = strtolower($file->getClientOriginalName());
			$img = preg_replace('/[^A-Za-z0-9\-.]/', '', $img);
    		$file->move('files/grid_image/', $img);
    		$preivew = '/files/grid_image/' . $img;

			return Response::json(array('error' => false, 'preivew' => $preivew), 200);
		}

		return Response::json(array('error' => true, 'message' => 'Error processing image'), 422);
	}

	public function edit($id)
	{
		$grid = GridImage::findOrFail($id);

		return View::make('pages.menu_items.edit', [ 'grid_image' => $grid ]);
	}

	public function update()
	{
		if(Input::has('grid_image_id')) {
			$image = GridImage::find(Input::get('grid_image_id'));
			if(Input::hasFile('grid_image')) {
				$file = Input::file('grid_image');
				$img = strtolower($file->getClientOriginalName());
				$filename = preg_replace('/[^A-Za-z0-9\-.]/', '', $img);
				$image->filename = $filename;
			}
			$image->url = Input::get('url');
			$image->save();

			return Response::json(array('error' => false, 'item' => $image), 200);
		}

		return Response::json(array('error' => true, 'message' => 'Error processing request'), 422);
	}
	
	public function destroy() {
		if(Input::has('id')) {
			GridImage::where('id', Input::get('id'))->delete();
			return Response::json(array('error' => false), 200);
		}

		return Response::json(array('error' => true, 'msg' => 'Error'), 400);
	}

	public function getImage() {
		if(Input::has('id')) {
			$image = GridImage::find(Input::get('id'));

			return Response::json(array('error' => false, 'image' => $image), 200);
		}

		return Response::json(array('error' => true, 'message' => 'Error processing request'), 422);
	}

	public function saveImage() {
		if(Input::has('id')) {
			$image = GridImage::find(Input::get('id'));
			$image->headline_de = Input::get('image_de');
			$image->headline_en = Input::get('image_en');
			$image->page_id = Input::get('page_id');
			$image->save();

			return Response::json(array('error' => false, 'image' => $image), 200);
		}

		return Response::json(array('error' => true, 'message' => 'Error processing request'), 422);
	}
}
