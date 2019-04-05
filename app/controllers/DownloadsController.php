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

        return Redirect::action('DownloadsController@index');
	}
	
	public function destroy($id) {
		Download::destroy($id);

		return Redirect::action('DownloadsController@index');
	}

	public function save() {
		// echo '<pre>'; print_r(Input::all()); exit;
		$local_dir = 'files/downloads/';
		$remote_dir = '../../'.SITE_DIR.'/public/files/downloads/';

		$page = Page::find(Input::get('page_id'));
		$link_title_de = (Input::has('link_title_de') && strlen(Input::get('link_title_de')) > 0) ? Input::get('link_title_de') : '';
		$link_title_en = (Input::has('link_title_en') && strlen(Input::get('link_title_en')) > 0) ? Input::get('link_title_en') : '';
    	$protected = (Input::has('protected') && Input::get('protected') == 'on') ? 1 : 0;
		$sort_order = (Input::has('sort_order') && is_numeric(Input::get('sort_order'))) ? Input::get('sort_order') : 1;
		if(Input::has('download_id') && is_numeric(Input::get('download_id')) && intval(Input::get('download_id')) > 0) {
			$dl = Download::find(Input::get('download_id'));
    		$dl->link_title_de = $link_title_de;
    		$dl->link_title_en = $link_title_en;
    		$dl->protected = $protected;
    		$dl->sort_order = $sort_order;
			if (Input::hasFile('download_file')) {
				$file = Input::file('download_file');
				$download_file = strtolower($file->getClientOriginalName());
	    		// $file->move('files/downloads/', $download_file);
	    		self::moveFile($local_dir, $remote_dir, $file);
	    		$dl->filename = $download_file;
	    	}	
			if (Input::hasFile('terms_file')) {
				$file = Input::file('terms_file');
				$terms_file = strtolower($file->getClientOriginalName());
	    		// $file->move('files/downloads/', $terms_file);
	    		self::moveFile($local_dir, $remote_dir, $file);
	    		$dl->terms_file = $terms_file;
	    		if(!Input::has('link_title_de') || strlen(Input::get('link_title_de')) == 0) {
	    			$link_title = $file->getClientOriginalName();
	    		}
	    	}	
			if (Input::hasFile('thumb')) {
				$file = Input::file('thumb');
				$thumb = strtolower($file->getClientOriginalName());
	    		// $file->move('files/downloads/', $thumb);
	    		self::moveFile($local_dir, $remote_dir, $file);
	    		$dl->thumb_image = $thumb;
	    		if(!Input::has('link_title_de') || strlen(Input::get('link_title_de')) == 0) {
	    			$link_title = $file->getClientOriginalName();
	    		}
	    	}	

    		$dl->link_title_de = (Input::has('link_title_de') && strlen(Input::get('link_title_de')) > 0) ? Input::get('link_title_de') : '';
    		$dl->link_title_en = (Input::has('link_title_en') && strlen(Input::get('link_title_en')) > 0) ? Input::get('link_title_en') : '';
			$dl->save();

		} else {
			$dl = new Download();
    		$dl->link_title_de = $link_title_de;
    		$dl->link_title_en = $link_title_en;
    		$dl->protected = $protected;
    		$dl->sort_order = $sort_order;
    		$link_title = '';
			if (Input::hasFile('download_file')) {
				$file = Input::file('download_file');
				$download_file = strtolower($file->getClientOriginalName());
	    		// $file->move('files/downloads/', $download_file);
	    		self::moveFile($local_dir, $remote_dir, $file);
	    		$dl->filename = $download_file;
	    		// if(!Input::has('link_title') || strlen(Input::get('link_title')) == 0) {
	    		// 	$link_title = $file->getClientOriginalName();
	    		// }
	    	}	
			if (Input::hasFile('terms_file')) {
				$file = Input::file('terms_file');
				$terms_file = strtolower($file->getClientOriginalName());
	    		// $file->move('files/downloads/', $terms_file);
	    		self::moveFile($local_dir, $remote_dir, $file);
	    		$dl->terms_file = $terms_file;
	    	}	
			if (Input::hasFile('thumb')) {
				$file = Input::file('thumb');
				$thumb = strtolower($file->getClientOriginalName());
	    		// $file->move('files/downloads/', $thumb);
	    		self::moveFile($local_dir, $remote_dir, $file);
	    		$dl->thumb_image = $thumb;
	    	}	
			$dl->page_id = Input::get('page_id');	
    		$link_title_de = (Input::has('link_title_de') && strlen(Input::get('link_title_de')) > 0) ? Input::get('link_title_de') : '';
			$link_title_de = substr($link_title_de, 0, strpos($link_title_de, '.'));
			$dl->link_title_de = $link_title_de;
    		$link_title_en = (Input::has('link_title_en') && strlen(Input::get('link_title_en')) > 0) ? Input::get('link_title_en') : '';
			$link_title_en = substr($link_title_en, 0, strpos($link_title_en, '.'));
			$dl->link_title_en = $link_title_en;
			$dl->save();

			$page->downloads()->save($dl);
		}

		return Redirect::action('PagesController@edit', ['menu_item_id' => Input::get('menu_item_id'), 'cs_id' => Input::get('cs_id'), 
				'id' => Input::get('page_id'), 'action' => 'downloads']);
	}

	public static function moveFile($loc_dir, $rem_dir, $file) {
		$filename = $file->getClientOriginalName();
		$filename = str_replace(' ', '_', $filename);
		if(!$file->move($rem_dir, $filename)) {
    		$file->move($loc_dir, $filename);
    		if(!copy($loc_dir.$filename, $rem_dir.$filename)) {
    			return false;
    		}
		}
		return true;
	}

	public function uploadDownloadFile() {
		if(Request::ajax()) {
			if (Input::hasFile('download_file')) {
				$file = Input::file('download_file');
				$filename = strtolower($file->getClientOriginalName());
				$filename = str_replace(' ', '_', $filename);
	    		$file->move('files/downloads/', $filename);
	    		$preivew = '/files/downloads/' . $filename;

	    		$type = strpos($filename, '.pdf') > 0 ? 'pdf' : 'image';	    		

				return Response::json(array('error' => false, 'preivew' => $preivew, 'type' => $type, 'filename' => $filename), 200);
			}
		}

		return Response::json(array('error' => true, 'message' => 'Error processing image'), 422);
	}

	public function uploadThumb() {
		if(Request::ajax()) {
			if (Input::hasFile('thumb')) {
				$file = Input::file('thumb');
				$filename = strtolower($file->getClientOriginalName());
				$filename = str_replace(' ', '_', $filename);
	    		$file->move('files/downloads/', $filename);
	    		$preivew = '/files/downloads/' . $filename;

				return Response::json(array('error' => false, 'preivew' => $preivew), 200);
			}
		}

		return Response::json(array('error' => true, 'message' => 'Error processing request'), 422);
	}

	public function getDownload() {
		if(Input::has('id') && intval(Input::get('id')) > 0) {
			$item = Download::find(Input::get('id'));			
			$filename = $item->filename;
			$type = strpos($filename, '.pdf') > 0 ? 'pdf' : 'image';

			return Response::json(array('error' => false, 'item' => $item, 'type' => $type, 'filename' => $filename), 200);
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
