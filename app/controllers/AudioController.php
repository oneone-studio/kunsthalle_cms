<?php

class AudioController extends BaseController {

	public function index()
	{
	}

	public function create()
	{
		return View::make('pages.menu_items.create');
	}

	public function store()
	{
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('http://www.google.com');
		}
		if(Input::has('audio')) {
			$log = "\nAudio store()";
			$max_sort_order = 1;
			$page_sections = DB::select('select max(sort_order)+1 as max_sort_order from page_sections where page_id = '. Input::get('page_id'));
			if(is_array($page_sections) && count($page_sections)) {
				if($page_sections[0]->max_sort_order != null && is_numeric($page_sections[0]->max_sort_order)) {
					$max_sort_order = $page_sections[0]->max_sort_order;
				}
			}

			$audio = new Audio();
			$url = Input::get('url');
			$url = str_replace('https://voicerepublic.com/embed/talks/', '', $url);
			$audio->url = $url;
			$audio->page_id = Input::get('page_id');
			$audio->save();

			PageSection::insert(['page_id' => Input::get('page_id'), 'audio_id' => $audio->id, 'sort_order' => $max_sort_order]);
			LogHelper::logcms($log);
		}		

		return Redirect::action('PagesController@edit', ['menu_item_id' => Input::get('menu_item_id'), 'cs_id' => Input::get('cs_id'), 'id' => Input::get('page_id')]);
	}

	public function save() {
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('http://www.google.com');
		}
		$log = "\nAudio save()";
		$url = Input::get('url');
		$url = str_replace('https://voicerepublic.com/embed/talks/', '', $url);
		if(Input::has('audio_id') && intval(Input::get('audio_id')) > 0) {
			$audio = Audio::find(Input::get('audio_id'));
			$audio->url = $url;
			$audio->save();
		} else {
			$max_sort_order = 1;
			$page_sections = DB::select('select max(sort_order)+1 as max_sort_order from page_sections where page_id = '. Input::get('page_id'));
			if(is_array($page_sections) && count($page_sections)) {
				if($page_sections[0]->max_sort_order != null && is_numeric($page_sections[0]->max_sort_order)) {
					$max_sort_order = $page_sections[0]->max_sort_order;
				}
			}

			$audio = new Audio();
			$audio->url = $url;
			$audio->page_id = Input::get('page_id');
			$audio->save();

			PageSection::insert(['page_id' => Input::get('page_id'), 'audio_id' => $audio->id, 'sort_order' => $max_sort_order]);
		}

		$params = [];
		if(Input::has('menu_item_id')) { $params[] = Input::get('menu_item_id'); }
		if(Input::has('cs_id')) { $params[] = Input::get('cs_id'); }
		if(Input::has('page_id')) { $params[] = Input::get('page_id'); }

		LogHelper::logcms($log);
		if(Input::has('menu_item_id')) {
			return Redirect::action('PagesController@edit', $params);
		} else {
			return Redirect::action('ExhibitionPagesController@edit', [Input::get('page_id')]);
		}
	}

	public function edit($id)
	{
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('http://www.google.com');
		}
		$log = "\nAudio edit()";
		$menu_item = MenuItem::findOrFail($id);
		LogHelper::logcms($log);

		return View::make('pages.menu_items.edit', [ 'menu_item' => $menu_item ]);
	}

	public function update()
	{
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('http://www.google.com');
		}
		$log = "\nAudio update()";
		if(Input::has('audio_id')) {
			$audio = Audio::find(Input::get('audio_id'));
			$audio->url = Input::get('url');
			$audio->save();
		}
		LogHelper::logcms($log);

		return Redirect::action('PagesController@edit', ['menu_item_id' => Input::get('menu_item_id'), 'cs_id' => Input::get('cs_id'), 'id' => Input::get('page_id')]);
	}
	
	public function destroy($id) {
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('http://www.google.com');
		}
		$log = "\nAudio destroy()";
		MenuItem::where('id', $id)->delete();
		LogHelper::logcms($log);

		return Redirect::action('MenuItemsController@index');
	}

	public function getAudio() {
		if(Input::has('id')) {
			$audio = Audio::find(Input::get('page_id'));

			return Response::json(array('error' => false, 'audio' => $audio), 200);
		}

		return Response::json(array('error' => true, 'message' => 'Error processing request'), 422);
	}

	public function saveAudio() {
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('http://www.google.com');
		}
		$log = "\nAudio saveAudio()";
		if(Input::has('id')) {
			$audio = Audio::find(Input::get('page_id'));
			$audio->url = Input::get('url');
			$audio->page_id = Input::get('page_id');
			$audio->save();

			return Response::json(array('error' => false, 'audio' => $audio), 200);
		}
		LogHelper::logcms($log);

		return Response::json(array('error' => true, 'message' => 'Error processing request'), 422);
	}
}
