<?php

class ExhibitionsController extends BaseController {

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
		$exhibitions = Exhibition::all()->sortByDesc('start_date');	
		// echo '<pre>'; print_r($exhibitions); exit; 
		$count = 0;
		if(!Session::has('Count')) {
			Session::put('Count', $count);
		}
		$count = Session::get('Count');
		++$count;
		Session::put('Count', $count);
		
		return View::make('pages.exhibitions.index', ['exhibitions' => $exhibitions] );
	}

	public function show()
	{
		// $events = Event::all();	

		return View::make('pages.exhibitions.index');//, ['events' => ['apples', 'oranges', 'mangoes'] ] ); // $events] );
	}

	public function create()
	{
		$clusters = Cluster::where('cluster_type', '=', 'exhibition')->get();
		return View::make('pages.exhibitions.create', [ 'clusters' => $clusters ]);
	}

	public function edit($id)
	{
		// $exhibition = Exhibition::find($id);
		$exhibition = Exhibition::with('gallery_images')->findOrFail($id);
		// echo '<pre>'; print_r($exhibition); exit;
		$clusters = Cluster::where('cluster_type', '=', 'exhibition')->get();
		$gallery_images = [];
		if(isset($exhibition->gallery_images)) {
			$gallery_images[] = $exhibition->gallery_image;
		}

		return View::make('pages.exhibitions.edit', [ 'exhibition' => $exhibition, 'clusters' => $clusters ]);
	}

	public function update()
	{
		$ex = Exhibition::find(Input::get('id'));
		$ex->title_de = Input::get('title_de');
		$ex->title_en = Input::get('title_en');
		$ex->subtitle_de = Input::get('subtitle_de');
		$ex->subtitle_en = Input::get('subtitle_en');
		$ex->start_date = Input::get('start_date');
		$ex->end_date = Input::get('end_date');
		$ex->content_de = Input::get('content_de');
		$ex->content_en = Input::get('content_en');

		if(Input::has('cluster')) {
			$cluster_id = Input::get('cluster');
			if(intval($cluster_id) > 0) {
				$cluster = Cluster::find($cluster_id);
				$ex->cluster()->save($cluster);
				// echo '<p>Saved cluster #' . $cluster->id . '</p>';
			}
		}	

		$ex->save();
		$ex = Exhibition::find(Input::get('id'));

		return Redirect::action('ExhibitionsController@index');
	}
	
	public function destroy($id) {
		Exhibition::destroy($id);

		return Redirect::action('ExhibitionsController@index');
	}

	public function store()
	{
		$input = Input::all();

		// echo '<pre>'; print_r($input); exit;
		// Event::create($input);

		$ex = new Exhibition;
		// $evt->create($input);
		/**/
		$ex->title_de = Input::get('title_de');
		$ex->title_en = Input::get('title_en');
		$ex->subtitle_de = Input::get('subtitle_de');
		$ex->subtitle_en = Input::get('subtitle_en');
		$ex->start_date = Input::get('start_date');
		$ex->end_date = Input::get('end_date');
		$ex->content_de = Input::get('content_de');
		$ex->content_en = Input::get('content_en');
		// print_r($ex); exit;
		$ex->save();
		/**/
        // $validation = Validator::make($input, User::$rules);
        // if ($validation->passes())
        // {
            // Event::create($input);

            return Redirect::action('ExhibitionsController@index');
        // }

        /*    
        return Redirect::route('events.create')
            ->withInput()
            // ->withErrors($validation)
            ->with('message', 'There were validation errors.');    
        /**/    
	}

	public function test() {
		return View::make('pages.exhibitions.test');
	}

	public function saveGalleryImage() {		
		if(Request::ajax()) {
			if (Input::hasFile('gallery_image')) {
				$file = Input::file('gallery_image');
				$filename = str_replace(' ', '', strtolower($file->getClientOriginalName()));
				$filename = ExhibitionsController::clean($filename);
	    		$file->move('images/gallery/', $filename);

	    		$image = new GalleryImage();
	    		$image->image = $filename;
	    		$image->exhibition_id = Input::get('id');
	    		$image->detail = Input::get('image_detail');
	    		$image->sort_order = 1;
	    		$image->save();

				return Response::json(array('error' => false, 'item' => $image), 200);
			}
		}

		return Response::json(array('error' => true, 'message' => 'Error creating product'), 422);
	}

	public static function clean($string) {
	   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

	   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}

	public function upload() {
		if(Request::ajax()) {
			if (Input::hasFile('gallery_image')) {
				$file = Input::file('gallery_image');
				$filename = str_replace(' ', '', strtolower($file->getClientOriginalName()));
				$filename = ExhibitionsController::clean($filename);
	    		$file->move('images/gallery/', $filename);
	    		$preivew = '/images/gallery/' . $filename;

				return Response::json(array('error' => false, 'preivew' => $preivew), 200);
			}
		}

		return Response::json(array('error' => true, 'message' => 'Error processing image'), 422);
	}

	public function editGalleryImage() {
		
		if(Request::ajax()) {
			if(Input::has('id')) {
				$image = GalleryImage::find(Input::get('id'));

				return Response::json(array('error' => false, 'item' => $image), 200);
			}
		}

		return Response::json(array('error' => true, 'message' => 'Error creating product'), 422);
	}

	public function updateGalleryImage() {
		if(Request::ajax()) {
			if(Input::has('image_id')) {
				$filename = '';
				if(Input::hasFile('gallery_image')) {
					$file = Input::file('gallery_image');
					$filename = str_replace(' ', '', strtolower($file->getClientOriginalName()));
					$filename = ExhibitionsController::clean($filename);
		    		$file->move('images/gallery/', $filename);

					$image = GalleryImage::find(Input::get('image_id'));
					if(strlen($filename) > 0) {
			    		$image->image = $filename;
					}
		    		$image->detail = Input::get('image_detail');
		    		$image->sort_order = 1;
		    		$image->save();
				}

				return Response::json(array('error' => false, 'item' => $image), 200);
			}
		}

		return Response::json(array('error' => true, 'message' => 'Error creating product'), 422);
	}

	public function deleteGalleryImage() {
		
		if(Request::ajax()) {
			if(Input::has('id')) {
				$img = GalleryImage::find(Input::get('id'));
				$img->delete();

				return Response::json(array('error' => false, 'item' => Input::get('id')), 200);
			}
		}

		return Response::json(array('error' => true, 'message' => 'Error creating product'), 422);
	}

}
