<?php

class PagesController extends BaseController {

	var $DOMAIN = '';

	public function __construct() {
		$http = (strpos($_SERVER['SERVER_PROTOCOL'], 'HTTP/') >= 0) ? 'http' : 'https';
		$this->DOMAIN = $http.'://'. $_SERVER['SERVER_NAME'];
	}

	public function index($menu_item_id, $cs_id = null)
	{
		$pages = [];
		if(isset($cs_id) && is_numeric($cs_id) && intval($cs_id) > 0) {
			$pages = Page::with('page_image_sliders')->where('content_section_id', $cs_id)->get()->sortBy('sort_order');	
		}
		// echo '<pre>'; print_r($pages); exit;
		$menu_item = MenuItem::find($menu_item_id);
		$cs = ContentSection::find($cs_id);

		return View::make('pages.pages.index', ['pages' => $pages, 'cs_id' => $cs_id, 'menu_item_id' => $menu_item_id, 'content_section' => $cs,
							'menu_item' => $menu_item, 'pages' => $pages]);
	}

	public function setPageOrder() {
		// echo '<pre>'; print_r(Input::all()); exit;
		if(Input::get('page_id')) {
			DB::table('pages')->where('id', Input::get('page_id'))
			                  ->update(['sort_order' => Input::get('sort_order')]);

			return Redirect::action('PagesController@index', [Input::get('menu_item_id'), Input::get('cs_id')]);
		}

		return Redirect::action('PagesController@index', [Input::get('menu_item_id'), Input::get('cs_id')]);
	}

	public function setMainTeaser($page_id, $menu_item_id, $cs_id) {
		DB::table('pages')->where('content_section_id', $cs_id)->update(['is_main_teaser' => 0]);
		DB::table('pages')->where('id', intval($page_id))->update(['is_main_teaser' => 1]);

		return Redirect::action('PagesController@index', [$menu_item_id, $cs_id]);
	}

	public function unsetMainTeaser($page_id, $menu_item_id, $cs_id) {
		DB::table('pages')->where('content_section_id', $cs_id)->update(['is_main_teaser' => 0]);
		DB::table('pages')->where('id', intval($page_id))->update(['is_main_teaser' => 0]);

		return Redirect::action('PagesController@index', [$menu_item_id, $cs_id]);
	}

	public function show()
	{
		// $events = Event::all();
		return View::make('pages.pages.index');//, ['events' => ['apples', 'oranges', 'mangoes'] ] ); // $events] );
	}

	public function createSectionPage($menu_item_id, $cs_id)
	{
		return View::make('pages.pages.create-sp', ['menu_item_id' => $menu_item_id, 'cs_id' => $cs_id]);
	}

	public function storeSectionPage()
	{
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('http://www.google.com');
		}
		if(Input::has('cs_id')) {
			$page = new Page;
			$page->title_de = Input::get('title_de');
			$page->title_en = Input::get('title_en');
			$page->active = Input::has('active') ? 1 : 0;
			if(Input::has('contacts') && count(Input::get('contacts'))) {
				$page->contacts()->sync(Input::get('contacts')); // attach contacts
			} else {
			    $page->contacts()->detach(); // detatch contacts
			}
			$page->save();

			$cs = ContentSection::find(Input::get('cs_id'));
			$cs->active = Input::has('active') ? 1 : 0;
			$cs->pages()->save($page);

			$menu = MenuItem::find(Input::get('menu_item_id'));
			$menu->content_sections()->save($cs);

	        return Redirect::action('PagesController@edit', ['menu_item_id' => Input::get('menu_item_id'), 'cs_id' => Input::get('cs_id'), 
	        					'id' => $page->id]);
		}

		return Redirect::action('ContentSectionsController@index');
	}

	public function create($cs_id)
	{
		$content_section = new ContentSection();
		$content_section->title_de = 'New Page';
		$content_section->title_en = 'New Page';
		$content_section->save();

		return View::make('pages.pages.create', ['cs_id' => $content_section->id]);
	}

	public function store()
	{
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('http://www.google.com');
		}
		// echo 'update()<pre>'; print_r(Input::all()); exit;
		if(Input::has('title_de')) {
			$page = new Page;
			$page->title_de = Input::get('title_de');
			$page->title_en = Input::get('title_en');
			$page->seo_page_title = Input::get('seo_page_title');
			$page->seo_page_desc = Input::get('seo_page_desc');
			$slug = strtolower(str_replace(' ', '-', Input::get('slug')));
			$reps = [ 'ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue', 'Ä' => 'Ae', 'Ö' => 'Oe', 'Ü' => 'Ue', 'ß' => 'ss' ];
			foreach($reps as $char => $rep) {
				$slug = str_replace($char, $rep, $slug);
			}
			$page->slug = $slug;
			$page->cluster_id = Input::get('cluster_id');
			$page->active = Input::has('active') ? 1 : 0;
			$page->save();
			if(Input::has('contacts') && count(Input::get('contacts'))) {
				$page->contacts()->sync(Input::get('contacts')); // attach contacts
			} else {
			    $page->contacts()->detach(); // detatch contacts
			}

			$cs = ContentSection::find(Input::get('cs_id'));
			if($cs->type == 'page') {
				$cs->active = Input::has('active') ? 1 : 0;
				$cs->pages()->save($page);
				$cs->save();
			}	
			if($cs->type == 'page_section') {
				$query = 'select count(id) as cnt from pages where content_section_id = '. $cs->id;
				$res = DB::select($query);
				if($res) {
					if($res[0]->cnt == 0) {
						$cs->active = 0;
						$cs->save();
					}
				}
			}

	        return Redirect::action('PagesController@edit', ['menu_item_id' => Input::get('menu_item_id'), 'cs_id' => Input::get('cs_id'), 'id' => $page->id]);
		}

		return Redirect::action('ContentSectionsController@index');
	}

	public function saveDLProtection() {
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('http://www.google.com');
		}
		// echo 'updatsaveDLProtectione()<pre>'; print_r(Input::all()); exit;	
		if(Input::has('page_id')) {
			$page = Page::find(Input::get('page_id'));		
			$page->dl_protected = Input::has('protected') ? 1 : 0;	
			if (Input::hasFile('terms_file')) {
				$file = Input::file('terms_file');
				$terms_file = strtolower($file->getClientOriginalName());
	    		$file->move('files/downloads/', $terms_file);
	    		$page->dl_terms_file = $terms_file;
	    	}	
	    	$page->save();
		}

		return Redirect::action('PagesController@edit', ['menu_item_id' => Input::get('menu_item_id'), 'cs_id' => Input::get('cs_id'), 
				'id' => Input::get('page_id'), 'action' => 'downloads']);
	}

	public function deleteDLTermsFile() {
		if(Input::has('page_id')) {
			$page = Page::find(Input::get('page_id'));		
    		$page->dl_protected = 0;
    		$page->dl_terms_file = '';
	    	$page->save();

	    	return Response::json(array('error' => false), 200);
		}

		return Response::json(array('error' => true), 401);
	}

	public function resetDLProtection() {
		if(Input::has('page_id')) {
			$page = Page::find(Input::get('page_id'));		
    		$page->dl_protected = 0;
    		$page->dl_terms_file = '';
	    	$page->save();

	    	return Response::json(array('error' => false), 200);
		}

		return Response::json(array('error' => true), 401);
	}

	public function storeSinglePage()
	{
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('http://www.google.com');
		}
		// echo 'update()<pre>'; print_r(Input::all()); exit;
		if(Input::has('title_de')) {
			$page = new Page;
			$page->title_de = Input::get('title_de');
			$page->title_en = Input::get('title_en');
			$page->cluster_id = Input::get('cluster_id');
			$page->active = Input::has('active') ? 1 : 0;
			$page->save();
			if(Input::has('contacts') && count(Input::get('contacts'))) {
				$page->contacts()->sync(Input::get('contacts')); // attach contacts
			} else {
			    $page->contacts()->detach(); // detatch contacts
			}

			$cs = ContentSection::find(Input::get('cs_id'));
			if($cs->type == 'page') {
				$cs->title_de = Input::get('title_de');
				$cs->title_en = Input::get('title_en');
				$cs->active = Input::has('active') ? 1 : 0;
				$cs->save();
			}	

			$cs->pages()->save($page);

			$mi = MenuItem::find(Input::get('menu_item_id'));
			$mi->content_sections()->save($cs);

	        return Redirect::action('PagesController@edit', ['menu_item_id' => Input::get('menu_item_id'), 'cs_id' => Input::get('cs_id'), 'id' => $page->id]);
		}

		return Redirect::action('ContentSectionsController@index');
	}

	public function editSectionPage($menu_item_id, $cs_id, $id, $action = null)
	{
		$page = Page::with(['page_contents', 'page_image_sliders', 'cluster', 'page_image_sliders.page_slider_images'])->findOrFail($id);
		$_clusters = Cluster::all();
		$clusters = [];
		$cluster_match = false;
		foreach($_clusters as $c) {
			if($c->id == $page->cluster_id) { $clusters[] = $c; $cluster_match = true; break; }
		}
		foreach($_clusters as $c) {
			if($c->id != $page->cluster_id) { $clusters[] = $c; }
		}
		$_contacts = Contact::all();
		$contacts = [];
		$rel_contacts = [];
		$ids = [];
		foreach($page->contacts as $c) { $rel_contacts[] = $c; $ids[] = $c->id; }
		foreach($_contacts as $c) {
			if(!in_array($c->id, $ids)) { $contacts[] = $c; }
		}
		$page_count = 0;
		$pages = Page::where('content_section_id', $cs_id)->get();
		if($pages) {
			$page_count = count($pages);
		}
		$content_section = ContentSection::find($cs_id);

		$p_sections = PageSection::where('page_id', $page->id)->orderBy('sort_order')->get();
		$sections = PagesController::getPageSections($id);

		$sort_limit = 1;
		$page_sections = DB::select('select count(id) as max_sort_order from page_sections where page_id = '. $page->id);
		if(is_array($page_sections) && count($page_sections)) {
			$sort_limit = $page_sections[0]->max_sort_order;
		}
		// if($page->page_contents) { $sort_limit += count($page->page_contents);	 }
		// if($page->page_image_sliders) { $sort_limit += count($page->page_image_sliders); }
		$params = ['page' => $page, 'sections' => $sections, 'content_section' => $content_section, 
						'cs_id' => $cs_id, 'DOMAIN' => $this->DOMAIN, 'sort_limit' => $sort_limit, 'page_count' =>$page_count, 
						'menu_item_id' => $menu_item_id, 'clusters' => $clusters, 'cluster_match' => $cluster_match, 'rel_contacts' => $rel_contacts, 'contacts' => $contacts];
		$action_val = '';		  
		if(isset($action)) {
			$action_val = $action;
		}		  
		$params['action'] = $action_val;
		
		return View::make('pages.pages.edit-sp', $params);
	}

	public function edit($menu_item_id, $cs_id, $id, $action = null)
	{
		$page = Page::with(['page_contents', 'page_image_sliders', 'sponsor_groups', 'sponsor_groups.sponsors', 'h2text', 'downloads', 
			'cluster', 'banner', 'banner.banner_text', 'page_image_sliders.page_slider_images', 'image_grids', 'image_grids', 
			'image_grids.grid_images', 'tags'])->findOrFail($id);

		$query = 'select type from content_sections where id = '. $page->content_section_id;
		$res = DB::select($query);
		$tag_ids = [];
		$tags = [];
		if($page->tags && count($page->tags)) {
			foreach($page->tags as $t) {
				$tag_ids[] = $t->id;
			}
		}
		$isSectionPage = false;
		if($res) {
			$tags = Tag::all()->sortBy('tag_de');
			if(count($res)) {
				if($res[0]->type == 'page_section') {
					$isSectionPage = true;
				}
			}
		}
		$_clusters = Cluster::all();
		$clusters = [];
		$cluster_match = false;
		foreach($_clusters as $c) {
			if($c->id == $page->cluster_id) { $clusters[] = $c; $cluster_match = true; break; }
		}
		foreach($_clusters as $c) {
			if($c->id != $page->cluster_id) { $clusters[] = $c; }
		}
		$_contacts = Contact::all();
		$contacts = [];
		$rel_contacts = [];
		$ids = [];
		foreach($page->contacts as $c) { $rel_contacts[] = $c; $ids[] = $c->id; }
		foreach($_contacts as $c) {
			if(!in_array($c->id, $ids)) { $contacts[] = $c; }
		}
		$_sponsor_grps = SponsorGroup::all();
		$sponsor_grps = [];
		$rel_sponsor_grps = [];
		$ids = [];
		// foreach($page->sponsor_groups as $c) { $rel_sponsors[] = $c; $ids[] = $c->id; }
		// foreach($_sponsors as $c) {
		// 	if(!in_array($c->id, $ids)) { $sponsors[] = $c; }
		// }

		foreach($_clusters as $c) {
			if($c->id != $page->cluster_id) { $clusters[] = $c; }
		}

		$page_count = 0;
		$pages = Page::where('content_section_id', $cs_id)->get();
		if($pages) {
			$page_count = count($pages);
		}
		$content_section = ContentSection::find($cs_id);

		$p_sections = PageSection::where('page_id', $page->id)->orderBy('sort_order')->get();
		$sections = PagesController::getPageSections($id);

		$sort_limit = 1;
		$sort_res = DB::select('select count(id) as max_sort_order from page_sections where page_id = '. $page->id);
		if(is_array($sort_res) && count($sort_res)) {
			$sort_limit = $sort_res[0]->max_sort_order;
		}
		$downloads = $page->downloads->toArray();
		usort($downloads, function($a, $b) {
			if($a['sort_order'] == $b['sort_order']) { return 0; }
			return $a['sort_order'] > $b['sort_order'] ? 1 : -1;
		});

		// if($page->page_contents) { $sort_limit += count($page->page_contents);	 }
		$params = [ 'page' => $page, 'sections' => $sections, 'content_section' => $content_section, 
					'cs_id' => $cs_id, 'DOMAIN' => $this->DOMAIN, 'sort_limit' => $sort_limit, 'page_count' =>$page_count, 'tags' => $tags, 
					'tag_ids' => $tag_ids, 'menu_item_id' => $menu_item_id, 'clusters' => $clusters, 'cluster_match' => $cluster_match, 
					'rel_contacts' => $rel_contacts, 'contacts' => $contacts, 'isSectionPage' => $isSectionPage, 'downloads' => $downloads
				  ];
		$action_val = '';		  
		if(isset($action)) {
			$action_val = $action;
		}		  
		$params['action'] = $action_val;
		// echo '<pre>'; print_r($page->image_grids);exit;

		return View::make('pages.pages.edit', $params);
	}

	public function update()
	{
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('http://www.google.com');
		}
		// echo 'update()<pre>'; print_r(Input::all()); exit;	
		$page = Page::findOrFail(Input::get('id'));

		$page->title_de = Input::get('title_de');
		$page->title_en = Input::get('title_en');
		$page->seo_page_title = Input::get('seo_page_title');
		$page->seo_page_desc = Input::get('seo_page_desc');
		$slug = strtolower(str_replace(' ', '-', Input::get('slug')));
		$reps = [ 'ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue', 'Ä' => 'Ae', 'Ö' => 'Oe', 'Ü' => 'Ue', 'ß' => 'ss' ];
		foreach($reps as $char => $rep) {
			$slug = str_replace($char, $rep, $slug);
		}
		$page->slug = $slug;
		$page->cluster_id = Input::get('cluster_id');
		if(Input::has('contacts') && count(Input::get('contacts'))) {
			$page->contacts()->sync(Input::get('contacts')); // attach contacts
		} else {
		    $page->contacts()->detach(); // detatch contacts
		}
		if(Input::has('tags') && count(Input::get('tags'))) {
			$page->tags()->sync(Input::get('tags')); // attach tags
		} else {
		    $page->tags()->detach(); // detatch tags
		}
		// $page->sort_order = Input::get('sort_order');
		$page->active = Input::has('active') ? 1 : 0;
		$page->save();

		$cs = ContentSection::find(Input::get('cs_id'));
		if($cs->type == 'page') {
			$cs->title_de = Input::get('title_de');
			$cs->title_en = Input::get('title_en');
			$cs->active = Input::has('active') ? 1 : 0;
			$cs->save();
		}
		if($cs->type == 'page_section') {
			$query = 'select count(id) as cnt from pages where content_section_id = '. $cs->id;
			$res = DB::select($query);
			if($res) {
				if($res[0]->cnt == 0) {
					$cs->active = 0;
					$cs->save();
				}
			}
		}

        return Redirect::action('ContentSectionsController@index', ['menu_item_id' => Input::get('menu_item_id')]);
	}

	public static function getPageSections($page_id = 0) {
		$sections = [];
		if($page_id > 0) {
			$p_sections = PageSection::where('page_id', $page_id)->orderBy('sort_order')->get();
			if($p_sections != null && count($p_sections)) {
				foreach($p_sections as $ps) {
					$result = [];
					if($ps->content_id > 0) {
						$result = PageContent::find($ps->content_id);
						if(isset($result)) {
							$result->type = 'content';
						}
					} elseif($ps->gallery_id > 0) {
						$result = PageImageSlider::with('page_slider_images')->find($ps->gallery_id);
						if(isset($result)) {
							$result->type = 'slider';
						}	
					} elseif($ps->image_grid_id > 0) {
						$result = ImageGrid::with('grid_images')->find($ps->image_grid_id);
						if(isset($result)) {
							$result->type = 'image_grid';
						}	
					} elseif($ps->h2_id > 0) {
						$result = H2::find($ps->h2_id);
						if(isset($result)) {
							$result->type = 'h2';
						}	
					} elseif($ps->youtube_id > 0) {
						$result = Youtube::find($ps->youtube_id);
						if(isset($result)) {
							$result->type = 'youtube';
						}	
					} elseif($ps->audio_id > 0) {
						$result = Audio::find($ps->audio_id);
						if(isset($result)) {
							$result->type = 'audio';
						}	
					} elseif($ps->image_id > 0) {
						$result = Image::find($ps->image_id);
						if(isset($result)) {
							$result->type = 'image';
						}	
					} elseif($ps->h2_text_id > 0) {
						$result = H2text::find($ps->h2_text_id);
						if(isset($result)) {
							$result->type = 'h2text';
						}	
					}
					if(count($result)) {
						$result['ps_id'] = $ps->id;
						$sections[] = $result;
					}
				}
			}
		}
		// echo '<pre>'; print_r($sections); exit;
		return $sections;		
	}

	public function preview($menu_item_id, $cs_id, $id) {
		$sections = PagesController::getPageSections($id);

		return View::make('pages.pages.preview', ['sections' => $sections, 'menu_item_id' => $menu_item_id, 'cs_id' => $cs_id, 'page_id' => $id]);
	}

	// public function __preview($cs_id, $id) {
	// 	$sections = PagesController::getPageSections($id);

	// 	return View::make('pages.pages.preview', ['sections' => $sections, 'cs_id' => $cs_id, 'page_id' => $id]);		
	// }

	public function updateSectionPage()
	{
		$page = Page::findOrFail(Input::get('id'));

		$page->title_de = Input::get('title_de');
		$page->title_en = Input::get('title_en');
		$page->sort_order = Input::get('sort_order');
		$page->active = Input::has('active') ? 1 : 0;
		$page->save();

		// $cs = ContentSection::find(Input::get('cs_id'));
		// $cs->save();

        return Redirect::action('PagesController@index', ['menu_item_id' => Input::get('menu_item_id'), 'cs_id' => Input::get('cs_id')]);
	}	

	public function destroy($menu_item_id, $cs_id, $id) {
		$cs = ContentSection::find($cs_id);
		PageSection::where('page_id', $id)->delete();
		PageContent::where('page_id', $id)->delete();
		$sliders = PageImageSlider::where('page_id', $id)->get();
		foreach($sliders as $s) {
			PageSliderImage::where('page_image_slider_id', $s->id)->delete();
		}
		PageImageSlider::where('page_id', $id)->delete();
		Page::where('id', $id)->delete();

		if($cs->type == 'page') {
			ContentSection::where('id', $cs_id)->delete();

			return Redirect::action('ContentSectionsController@index', ['menu_item_id' => $menu_item_id]);
		}

		return Redirect::action('ContentSectionsController@index', ['menu_item_id' => $menu_item_id]);
	}

	public function test() {
		return View::make('pages.pages.test');
	}

	public function deleteBanner() {
		$f = fopen('logs/pages.log', 'w+');
		fwrite($f, "deleteBanner()\n\n".print_r(Input::all(), true));
		if(Input::has('banner_id')) {
			Banner::where('id', Input::get('banner_id'))->delete();
		}

		return Response::json(array('error' => false), 200);
	}

	public function deletePage($menu_item_id, $cs_id, $page_id) {
		Page::where('id', $page_id)->delete();

		return Redirect::action('PagesController@index', ['menu_item_id' => $menu_item_id, 'cs_id' => $cs_id]);
	}

	public function saveBanner() {
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('http://www.google.com');
		}
		$page = Page::find(Input::get('id'));
		$new_image = false;
		$banner_img = '';
		if (Input::hasFile('banner_image')) {
			$new_image = true;
			$file = Input::file('banner_image');
			$banner_img = 'p'. str_replace(' ', '', strtolower($file->getClientOriginalName()));
    		$file->move('files/pages/', $banner_img);
    	}	

		if(intval(Input::get('banner_id')) == 0) {
    		$banner = new Banner();
    		if($new_image) {
    			$banner->image = $banner_img;
    		}
    		$banner->page_id = $page->id;
    		$banner->text_position = Input::get('position');
    		$banner->save();	

    		$text = new BannerText();
    		for($n=1; $n<20; $n++) {
	    		if(Input::has('line_'.$n) && strlen(trim(Input::get('line_'.$n))) > 0) {
		    		$text::insert(['banner_id' => $banner->id, 
		    			  'line' => Input::get('line_'.$n), 'size' => Input::get('line_'.$n.'_size'),
		    			]);
	    		}    		
    		}
    		$page->banner()->save($banner);

		} else {

    		$banner = Banner::with('banner_text')->find(Input::get('banner_id'));
    		if($new_image) {
    			$banner->image = $banner_img;
    		}
    		$banner->text_position = Input::get('position');
			$banner->save();
    		$page->banner()->save($banner);				

	        return Redirect::action('PagesController@edit', ['menu_item_id' => Input::get('menu_item_id'), 'cs_id' => Input::get('cs_id'), 'id' => $page->id, 
	        	'action' => 'banner']);
		}

        return Redirect::action('PagesController@edit', ['menu_item_id' => Input::get('menu_item_id'), 'cs_id' => Input::get('cs_id'), 'id' => Input::get('id'), 'action' => 'banner']);
	}

	public function uploadPageImage() {
		if(Request::ajax()) {
			if (Input::hasFile('banner_image')) {
				$file = Input::file('banner_image');
				$img = strtolower($file->getClientOriginalName());
	    		$file->move('files/pages/', $img);
	    		$preivew = '/files/pages/' . $img;

				return Response::json(array('error' => false, 'preivew' => $preivew), 200);
			}
		}

		return Response::json(array('error' => true, 'message' => 'Error processing image'), 422);
	}

	public function getBanner() {
		$banner = Banner::with(['banner_text'])->find(Input::get('id'));

		return Response::json(array('error' => false, 'banner' => $banner), 200);
	}

	public function deletePageBanner($banner_id, $menu_item_id, $cs_id, $id) {
		$page = Page::find($id);
		Banner::where('id', $banner_id)->delete();

        return Redirect::action('PagesController@edit', ['menu_item_id' => $menu_item_id, 'cs_id' => $cs_id, 'id' => $id]);
	}

	public function getBannerText() {
		$text = BannerText::find(Input::get('id'));

		return Response::json(array('error' => false, 'text' => $text), 200);
	}

	public function deleteBannerText() {
		BannerText::where('id', Input::get('id'))->delete();

		return Response::json(array('error' => false, 'msg' => 'deleted'), 200);
	}

	public function saveBannerText() {
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('http://www.google.com');
		}
		$text = [];
		if(intval(Input::get('id')) == 0) {
			$text = new BannerText();
			$id = DB::table('banner_text')->insertGetId([
						   'banner_id' => Input::get('banner_id'),
						   'line_de' => Input::get('line_de'),
						   'line_en' => Input::get('line_en'),
			               'size' => Input::get('size')]);
			$text = BannerText::find($id);
		} else {
			BannerText::where('id', Input::get('id'))
			    ->update(['line_de' => Input::get('line_de'), 'line_en' => Input::get('line_en'), 'size' => Input::get('size')]);
			$text = BannerText::find(Input::get('id'));
		}

		return Response::json(array('error' => false, 'text' => $text), 200);
	}

	public function deletePageImage() {
		if(Request::ajax()) {
    		$page = Page::find(Input::get('id'));
    		$page->page_image = '';
    		$page->save();

			return Response::json(array('error' => false, 'page' => $page), 200);
		}

		return Response::json(array('error' => true, 'message' => 'Error processing savePageImage()'), 422);
	}	

	public function editStartPage()
	{
		$page = Page::with(['page_image_sliders', 'page_image_sliders.page_slider_images', 'page_image_sliders.page_slider_images.slide_text'])
						->where('page_type', 'start_page')->first();
		$slider = [];
		$slider_id = 0;
		if(!$page) {
			$page_id = Page::insertGetId(['title_de' => 'Kunsthalle Bremen', 'title_en' => 'Kunsthalle Bremen', 'page_type' => 'start_page']);
			if($page_id) {
				$slider = new PageImageSlider();
				$slider->title = 'start_page_slider';
				$slider->page_id = $page_id;
				$slider->save();
			}
		} else {
			// print_r($page->page_image_sliders[0]); exit;
			$slider = $page->page_image_sliders[0];
		}
		// echo '<pre>'; print_r($page); exit;

		$params = ['page' => $page, 'slider' => $slider, 'slider_id' => $slider->id];

		return View::make('pages.start-page.edit', $params);
	}	

	public function deleteSlide($slide_id, $id) {
		$page = Page::find($id);
		PageSliderImage::where('id', $id)->delete();

        return Redirect::action('PagesController@editStartPage');
	}

	public function getSlideText() {
		$text = SlideText::find(Input::get('id'));

		return Response::json(array('error' => false, 'text' => $text), 200);
	}

	public function deleteSlideText() {
		SlideText::where('id', Input::get('id'))->delete();

		return Response::json(array('error' => false, 'msg' => 'deleted'), 200);
	}

	public function saveSlideText() {
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('http://www.google.com');
		}
		$text = [];
		$f = fopen('test.log', 'w+');
		fwrite($f, date('d-m-Y H:i') ."\n\n". print_r(Input::all(), true));
		if(intval(Input::get('id')) == 0) {
			$text = new SlideText();
			$id = DB::table('slide_text')->insertGetId([
						   'page_slider_image_id' => Input::get('slide_id'),
						   'line' => Input::get('line'),
			               'size' => Input::get('size')]);
			$text = SlideText::find($id);
		} else {
			SlideText::where('id', Input::get('id'))
			    		->update(['line' => Input::get('line'), 'size' => Input::get('size')]);
			$text = SlideText::find(Input::get('id'));
		}

		return Response::json(array('error' => false, 'text' => $text), 200);
	}
}
