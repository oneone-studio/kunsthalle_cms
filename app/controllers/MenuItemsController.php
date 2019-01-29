<?php

class MenuItemsController extends BaseController {

	public function index()
	{
		$menu_items = MenuItem::with(['content_sections'])->get()->sortBy('sort_order');	

		return View::make('pages.menu_items.index', ['menu_items' => $menu_items]);
	}

	public function show()
	{
		return View::make('pages.menu_items.index');
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
		$menu_item = new MenuItem();
		$menu_item->title_de = Input::get('title_de');
		$menu_item->title_en = Input::get('title_en');
		$slug = strtolower(str_replace(' ', '-', Input::get('slug')));
		$reps = [ 'ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue', 'Ä' => 'Ae', 'Ö' => 'Oe', 'Ü' => 'Ue', 'ß' => 'ss' ];
		foreach($reps as $char => $rep) {
			$slug = str_replace($char, $rep, $slug);
		}
		$menu_item->slug = $slug;
		$menu_item->save();

        return Redirect::action('MenuItemsController@index');
	}

	public function updateSort($id, $new_order) {
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('http://www.google.com');
		}
		$mi = MenuItem::find($id);
		$old_order = $mi->sort_order;
		if($old_order < $new_order) {
			$items = MenuItem::where('sort_order', '>', $old_order)->where('sort_order', '<=', $new_order)->get();
			// foreach($items as $i) { echo $i->id . ' : '. $i->sort_order.'<br>'; } exit;
			foreach($items as $item) {
				$item->sort_order = intval($item->sort_order)-1;
				$item->save();
			}
		} elseif($old_order > $new_order) {
			$items = MenuItem::where('sort_order', '>=', $new_order)->where('sort_order', '<', $old_order)->get();
			foreach($items as $item) {
				$item->sort_order = intval($item->sort_order)+1;
				$item->save();
			}
		}
		$mi->sort_order = $new_order;		
		$mi->save();

        return Redirect::action('MenuItemsController@index');
	}

	public function edit($id)
	{
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('http://www.google.com');
		}
		$menu_item = MenuItem::findOrFail($id);

		return View::make('pages.menu_items.edit', [ 'menu_item' => $menu_item ]);
	}

	public function update()
	{
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('http://www.google.com');
		}
		$menu_item = MenuItem::findOrFail(Input::get('id'));

		$menu_item->title_de = Input::get('title_de');
		$menu_item->title_en = Input::get('title_en');
		$slug = strtolower(str_replace(' ', '-', Input::get('slug')));
		$reps = [ 'ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue', 'Ä' => 'Ae', 'Ö' => 'Oe', 'Ü' => 'Ue', 'ß' => 'ss' ];
		foreach($reps as $char => $rep) {
			$slug = str_replace($char, $rep, $slug);
		}
		$menu_item->slug = $slug;
		// $menu_item->sort_order = Input::get('sort_order');
		$menu_item->save();

        return Redirect::action('MenuItemsController@index');
	}
	
	public function destroy($id) {
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('http://www.google.com');
		}
		MenuItem::where('id', $id)->delete();

		return Redirect::action('MenuItemsController@index');
	}
}
