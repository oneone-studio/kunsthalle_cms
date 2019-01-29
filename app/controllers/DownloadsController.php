<?php

class DownloadsController extends BaseController {

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
		return View::make('pages.downloads.index');
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

        return Redirect::action('DownloadsController@index');
	}
	
	public function destroy($id) {
		Download::destroy($id);

		return Redirect::action('DownloadsController@index');
	}

	public function save() {
		// echo '<pre>'; print_r(Input::all()); exit;
		$page = Page::find(Input::get('page_id'));
		if(Input::has('download_id') && is_numeric(Input::get('download_id')) && intval(Input::get('download_id')) > 0) {
			$sp = Download::find(Input::get('download_id'));
			$sp->sort_order = Input::has('sort_order') ? Input::get('sort_order') : count($page->downloads);
    		$sp->protected = Input::has('protected') ? 1 : 0;
    		$link_title = (Input::has('link_title') && strlen(Input::get('link_title')) > 0) ? Input::get('link_title') : '';
			if (Input::hasFile('download_file')) {
				$file = Input::file('download_file');
				$download_file = strtolower($file->getClientOriginalName());
	    		$file->move('files/downloads/', $download_file);
	    		$sp->filename = $download_file;
	    		// if(!Input::has('link_title') || strlen(Input::get('link_title')) == 0) {
	    		// 	$link_title = $file->getClientOriginalName();
	    		// }
	    	}	
			if (Input::hasFile('terms_file')) {
				$file = Input::file('terms_file');
				$terms_file = strtolower($file->getClientOriginalName());
	    		$file->move('files/downloads/', $terms_file);
	    		$sp->terms_file = $terms_file;
	    		if(!Input::has('link_title') || strlen(Input::get('link_title')) == 0) {
	    			$link_title = $file->getClientOriginalName();
	    		}
	    	}	
			if (Input::hasFile('thumb')) {
				$file = Input::file('thumb');
				$thumb = strtolower($file->getClientOriginalName());
	    		$file->move('files/downloads/', $thumb);
	    		$sp->thumb_image = $thumb;
	    		if(!Input::has('link_title') || strlen(Input::get('link_title')) == 0) {
	    			$link_title = $file->getClientOriginalName();
	    		}
	    	}	

			$link_title = (Input::has('link_title') && strlen(Input::get('link_title')) > 0) ? Input::get('link_title') : $link_title;
			$sp->link_title = $link_title;
			$sp->save();

		} else {
			$sp = new Download();
			$sp->sort_order = Input::has('sort_order') ? Input::get('sort_order') : count($page->downloads)+1;
    		$sp->protected = Input::has('protected') ? 1 : 0;
    		$link_title = '';
			if (Input::hasFile('download_file')) {
				$file = Input::file('download_file');
				$download_file = strtolower($file->getClientOriginalName());
	    		$file->move('files/downloads/', $download_file);
	    		$sp->filename = $download_file;
	    		// if(!Input::has('link_title') || strlen(Input::get('link_title')) == 0) {
	    		// 	$link_title = $file->getClientOriginalName();
	    		// }
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
			$sp->page_id = Input::get('page_id');	
			$link_title = (Input::has('link_title') && strlen(Input::get('link_title')) > 0) ? Input::get('link_title') : '';
			$link_title = substr($link_title, 0, strpos($link_title, '.'));
			$sp->link_title = $link_title;
// echo '<pre>'; print_r($sp); exit;	    	
			$sp->save();

			$page->downloads()->save($sp);
		}

		return Redirect::action('PagesController@edit', ['menu_item_id' => Input::get('menu_item_id'), 'cs_id' => Input::get('cs_id'), 'id' => Input::get('page_id'), 
			                     'action' => 'downloads']);
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

	public function uploadThumb() {
		if(Request::ajax()) {
			if (Input::hasFile('thumb')) {
				$file = Input::file('thumb');
				$img = strtolower($file->getClientOriginalName());
	    		$file->move('files/downloads/', $img);
	    		$preivew = '/files/downloads/' . $img;

				return Response::json(array('error' => false, 'preivew' => $preivew), 200);
			}
		}

		return Response::json(array('error' => true, 'message' => 'Error processing request'), 422);
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

        return Redirect::action('DownloadsController@index');
	}
}