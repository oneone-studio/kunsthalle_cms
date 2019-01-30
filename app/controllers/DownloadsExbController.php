<?php

class DownloadsExbController extends BaseController {

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
		$downloads = Download::get();	

		return View::make('pages.downloads.index', ['downloads' => $downloads]);
	}

	public function show()
	{
		// $events = Event::all();	

		return View::make('pages.downloads.index');//, ['events' => ['apples', 'oranges', 'mangoes'] ] ); // $events] );
	}

	public function create()
	{
		return View::make('pages.downloads.create');
	}

	public function edit($id)
	{
		$download = Download::findOrFail($id);

		return View::make('pages.downloads.edit', ['download' => $download]);
	}

	public function update()
	{
		$download = Download::findOrFail(Input::get('id'));
		$download->title = Input::get('title');
		$download->link_title_de = Input::get('link_title_de');
		$download->link_title_en = Input::get('link_title_en');
		$download_file = '';
		if (Input::hasFile('download_file')) {
			$new_image = true;
			$file = Input::file('download_file');
			$download_file = str_replace(' ', '_', strtolower($file->getClientOriginalName()));
			$download_file = filter_var($download_file, FILTER_SANITIZE_STRING);
			$download->download_file = $download_file;
    		$file->move('files/downloads/', $download_file);
    	}	
		$download->save();

        return Redirect::action('ExhibitionPagesController@edit', ['id' => $page_id]);
	}
	
	public function destroy($id) {
		Download::destroy($id);

		return Redirect::action('ExhibitionPagesController@index');
	}

	public function save() {
		// echo '<pre>'; print_r(Input::all()); exit;
		if(Input::has('download_id') && is_numeric(Input::get('download_id')) && intval(Input::get('download_id')) > 0) {
			$sp = Download::find(Input::get('download_id'));
    		$sp->link_title_de = (Input::has('link_title_de') && strlen(Input::get('link_title_de')) > 0) ? Input::get('link_title_de') : '';
    		$sp->link_title_en = (Input::has('link_title_en') && strlen(Input::get('link_title_en')) > 0) ? Input::get('link_title_en') : '';
			if (Input::hasFile('download_file')) {
				$file = Input::file('download_file');
				$download_file = strtolower($file->getClientOriginalName());
	    		$file->move('files/downloads/', $download_file);
	    		$sp->filename = $download_file;
	    	}	
			if (Input::hasFile('terms_file')) {
				$file = Input::file('terms_file');
				$terms_file = strtolower($file->getClientOriginalName());
	    		$file->move('files/downloads/', $terms_file);
	    		$sp->terms_file = $terms_file;
	    	}	
			if (Input::hasFile('thumb')) {
				$file = Input::file('thumb');
				$thumb = strtolower($file->getClientOriginalName());
	    		$file->move('files/downloads/', $thumb);
	    		$sp->thumb_image = $thumb;
	    	}	
			$sp->save();

		} else {
			$sp = new Download();
    		$sp->link_title_de = (Input::has('link_title_de') && strlen(Input::get('link_title_de')) > 0) ? Input::get('link_title_de') : '';
    		$sp->link_title_en = (Input::has('link_title_en') && strlen(Input::get('link_title_en')) > 0) ? Input::get('link_title_en') : '';
			if (Input::hasFile('download_file')) {
				$file = Input::file('download_file');
				$download_file = strtolower($file->getClientOriginalName());
	    		$file->move('files/downloads/', $download_file);
	    		$sp->filename = $download_file;
	    	}	
			if (Input::hasFile('terms_file')) {
				$file = Input::file('terms_file');
				$terms_file = strtolower($file->getClientOriginalName());
	    		$file->move('files/downloads/', $terms_file);
	    		$sp->terms_file = $terms_file;
	    	}	
			if (Input::hasFile('thumb')) {
				$file = Input::file('thumb');
				$thumb = strtolower($file->getClientOriginalName());
	    		$file->move('files/downloads/', $thumb);
	    		$sp->thumb_image = $thumb;
	    	}	
			$sp->save();

			$page = Page::find(Input::get('page_id'));
			$page->downloads()->save($sp);
		}

		return Redirect::action('ExhibitionPagesController@edit', ['id' => Input::get('page_id'), 'action' => 'downloads']);
	}

	public function uploadDownloadFile() {
		if(Request::ajax()) {
			if (Input::hasFile('download_file')) {
				$file = Input::file('download_file');
				$img = strtolower($file->getClientOriginalName());
	    		$file->move('files/downloads/', $img);
	    		$preivew = '/files/downloads/' . $img;

				return Response::json(array('error' => false, 'preivew' => $preivew), 200);
			}
		}

		return Response::json(array('error' => true, 'message' => 'Error processing image'), 422);
	}

	public function getDownload() {
		if(Input::has('id') && intval(Input::get('id')) > 0) {
			$item = Download::find(Input::get('id'));			

			return Response::json(array('error' => false, 'item' => $item), 200);
		}

		return Response::json(array('error' => true, 'message' => 'Error processing request'), 422);
	}

	public function deleteDownload() {
		if (Input::has('id')) {
			Download::where('id', Input::get('id'))->delete();

			return Response::json(array('error' => false, 'msg' => 'deleted'), 200);
		}

		return Response::json(array('error' => true, 'message' => 'Error processing request'), 422);
	}

	public function store()
	{
		// echo '<pre>'; print_r(Input::all()); exit;
		$download = new Download;
		$download->title = Input::get('title');
		$download->link_title = Input::get('link_title');
		$download_file = '';
		if (Input::hasFile('download_file')) {
			$new_image = true;
			$file = Input::file('download_file');
			$download_file = str_replace(' ', '_', strtolower($file->getClientOriginalName()));
			$download_file = filter_var($download_file, FILTER_SANITIZE_STRING);
			$download->download_file = $download_file;
    		$file->move('files/downloads/', $download_file);
    	}	
		$download->save();

        return Redirect::action('ExhibitionPagesController@index');
	}
}
