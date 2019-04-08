<?php

class ContentSectionsController extends BaseController {

	public function index($menu_item_id)
	{
		// $content_sections = ContentSection::where('menu_item_id', $menu_item_id)->get()->sortBy('sort_order');	
		$query = 'select cs.*, mi.title_de as menu_title from content_sections cs, menu_items mi 
		          where cs.menu_item_id = mi.id 
		            and cs.menu_item_id = '. $menu_item_id . ' 
		          group by cs.id 
		          order by cs.sort_order';
		$content_sections = DB::select($query);
		$menu_item = '';
		if($content_sections && count($content_sections)) {
			$menu_item = $content_sections[0]->menu_title;
		}
		// echo '<pre>'; print_r($content_sections); exit;
		return View::make('pages.content_sections.index', ['content_sections' => $content_sections, 'menu_item_id' => $menu_item_id, 'menu_item' => $menu_item]);
	}

	public function show()
	{
		// $events = Event::all();	

		return View::make('pages.content_sections.index');
	}

	public function create($menu_item_id)
	{
		$contacts = Contact::all();

		return View::make('pages.content_sections.create', ['menu_item_id' => $menu_item_id, 'contacts' => $contacts]);
	}

	public function createSinglePage($menu_item_id)
	{
		$content_section = new ContentSection();
		$content_section->title_de = 'New Page';
		$content_section->title_en = 'New Page';
		$content_section->save();

		return View::make('pages.pages.create-sp', ['menu_item_id' => $menu_item_id, 'cs_id' => $content_section->id]);
	}

	public function updateSort($id, $new_order) {
		$mi = ContentSection::find($id);
		$old_order = $mi->sort_order;
		if($old_order < $new_order) {
			$items = ContentSection::where('menu_item_id', $mi->menu_item_id)->
							where('sort_order', '>=', $old_order)->
							where('id', '!=', $id)->where('sort_order', '<=', $new_order)->get();
			// foreach($items as $i) { echo $i->id . ' : '. $i->sort_order.'<br>'; } exit;
			foreach($items as $item) {
				$order = $item->sort_order;
				if($order > 1) { 
					$order -= 1;
				} else {
					$order = count($items);
				}
				$item->sort_order = $order;
				$item->save();
			}
		} elseif($old_order > $new_order) {
			$items = ContentSection::where('menu_item_id', $mi->menu_item_id)->
							where('sort_order', '>=', $new_order)->
							where('id', '!=', $id)->
							where('sort_order', '<=', $old_order)->get();
			foreach($items as $item) {
				$item->sort_order = intval($item->sort_order)+1;
				$item->save();
			}
		}
		$mi->sort_order = $new_order;		
		$mi->save();

        return Redirect::action('ContentSectionsController@index', ['menu_item_id' => $mi->menu_item_id]);
	}

	public function store()
	{
		// echo '<pre>'; print_r(Input::all()); exit;
		$order = 1;
		// $items = ContentSection::select('max(sort_order) as max')->where('menu_item_id', Input::get('menu_item_id'))->get();
		$items = DB::select('select max(sort_order) as max from content_sections where menu_item_id = '. Input::get('menu_item_id'));
		if($items) {
			$order = $items[0]->max;
		}
		// echo '<br>done'; exit;

		$content_section = new ContentSection();
		$content_section->title_de = Input::get('title_de');
		$content_section->title_en = Input::get('title_en');
		$content_section->headline_de = Input::get('headline_de');
		$content_section->headline_en = Input::get('headline_en');
		$content_section->detail_de = Input::get('detail_de');
		$content_section->detail_en = Input::get('detail_en');
		$content_section->type = 'page_section';
		$content_section->sort_order = $order;
		$content_section->teaser_size = Input::get('teaser_size');
		$content_section->active_de = Input::has('active_de') ? 1 : 0;
		$content_section->active_en = Input::has('active_en') ? 1 : 0;
		$content_section->save();

		if(Input::has('contacts') && count(Input::get('contacts'))) {
			$content_section->contacts()->sync(Input::get('contacts')); // attach contacts
		}
		$menu = MenuItem::find(Input::get('menu_item_id'));
		$menu->content_sections()->save($content_section);

        // return Redirect::action('MenuItemsController@index');
		return Redirect::action('ContentSectionsController@index', ['menu_item_id' => Input::get('menu_item_id')]);
	}

	public function edit($menu_item_id, $id)
	{
		$content_section = ContentSection::with('contacts')->findOrFail($id);
		$_contacts = Contact::all();
		$contacts = [];
		$rel_contacts = [];
		$ids = [];
		foreach($content_section->contacts as $c) { $rel_contacts[] = $c; $ids[] = $c->id; }
		foreach($_contacts as $c) {
			if(!in_array($c->id, $ids)) { $contacts[] = $c; }
		}

		return View::make('pages.content_sections.edit', [ 'content_section' => $content_section, 'menu_item_id' => $menu_item_id, 'contacts'=>$contacts,
		                   'rel_contacts' => $rel_contacts ]);
	}

	public function update()
	{
		// echo '<pre>'; print_r(Input::all()); exit;
		$content_section = ContentSection::findOrFail(Input::get('id'));

		$content_section->title_de = Input::get('title_de');
		$content_section->title_en = Input::get('title_en');
		$content_section->headline_de = Input::get('headline_de');
		$content_section->headline_en = Input::get('headline_en');
		$content_section->detail_de = Input::get('detail_de');
		$content_section->detail_en = Input::get('detail_en');
		$content_section->teaser_size = Input::get('teaser_size');
		$content_section->active_de = Input::has('active_de') ? 1 : 0;
		$content_section->active_en = Input::has('active_en') ? 1 : 0;
		if(Input::has('contacts') && count(Input::get('contacts'))) {
			$content_section->contacts()->sync(Input::get('contacts')); // attach contacts
		} else {
		    $content_section->contacts()->detach(); // detatch contacts
		}
		$content_section->save();

        // return Redirect::action('MenuItemsController@index', ['menu_item_id' => Input::get('menu_item_id')]);
        return Redirect::action('ContentSectionsController@edit', ['menu_item_id' => Input::get('menu_item_id'), 'id' => Input::get('id')]);
	}
	
	public function destroy($menu_item_id, $id) {
		ContentSection::where('id', $id)->delete();

		return Redirect::action('ContentSectionsController@index', ['menu_item_id' => $menu_item_id]);
	}
}
