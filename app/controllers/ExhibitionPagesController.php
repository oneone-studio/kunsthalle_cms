<?php

class ExhibitionPagesController extends BaseController {

	var $DOMAIN = '';

	public function __construct() {
		$this->DOMAIN = 'http://'. $_SERVER['SERVER_NAME'];
	}

	public function index()
	{
		$exhibition_pages = [];
		$exhibition_pages = Page::with('page_image_sliders')
								 ->where('page_type', 'exhibition')
								 ->get();	
		// echo '<pre>'; print_r($exhibition_pages); exit;

		return View::make('pages.exhibition_pages.index', ['pages' => $exhibition_pages]);
	}

	public function show()
	{
		// $events = Event::all();	

		return View::make('pages.exhibition_pages.index');//, ['events' => ['apples', 'oranges', 'mangoes'] ] ); // $events] );
	}

	public function create()
	{
		$contacts = Contact::all();
		$clusters = Cluster::all();

		return View::make('pages.exhibition_pages.create', ['contacts' => $contacts, 'clusters' => $clusters]);
	}

	public function setMainExb($page_id) {
		DB::table('pages')->where('page_type', 'exhibition')->update(['is_main_teaser' => 0]);
		DB::table('pages')->where('id', intval($page_id))->update(['is_main_teaser' => 1]);

		return Redirect::action('ExhibitionPagesController@index');
	}

	public function unsetMainExb($page_id) {
		DB::table('pages')->where('page_type', 'exhibition')->update(['is_main_teaser' => 0]);

		return Redirect::action('ExhibitionPagesController@index');
	}

	public function store()
	{
		// echo 'update()<pre>'; print_r(Input::all()); exit;
		if(Input::has('title_de')) {
			$exhibition_page = new ExhibitionPage;
			$exhibition_page->title_de = Input::get('title_de');
			$exhibition_page->title_en = Input::get('title_en');
			$slug_de = strtolower(str_replace(' ', '-', Input::get('slug_de')));
			$slug_en = strtolower(str_replace(' ', '-', Input::get('slug_en')));
			$reps = [ 'ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue', 'Ä' => 'Ae', 'Ö' => 'Oe', 'Ü' => 'Ue', 'ß' => 'ss' ];
			foreach($reps as $char => $rep) {
				$slug_de = str_replace($char, $rep, $slug_de);
				$slug_en = str_replace($char, $rep, $slug_en);
			}
			$exhibition_page->slug_de = $slug_de;
			$exhibition_page->slug_en = $slug_en;
			$exhibition_page->seo_page_title_de = Input::get('seo_page_title_de');
			$exhibition_page->seo_page_title_en = Input::get('seo_page_title_en');
			$exhibition_page->seo_page_desc_de = Input::get('seo_page_desc_de');
			$exhibition_page->seo_page_desc_en = Input::get('seo_page_desc_en');
			$exhibition_page->cluster_id = Input::get('cluster_id');
			$exhibition_page->active_de = Input::has('active_de') ? 1 : 0;
			$exhibition_page->active_en = Input::has('active_en') ? 1 : 0;
			$exhibition_page->save();
			if(Input::has('contacts') && count(Input::get('contacts'))) {
				$exhibition_page->contacts()->sync(Input::get('contacts')); // attach contacts
			} else {
			    $exhibition_page->contacts()->detach(); // detatch contacts
			}

			$cs = ContentSection::find(Input::get('cs_id'));
			$cs->active = Input::has('active_de') ? 1 : 0;
			$cs->active_de = Input::has('active_de') ? 1 : 0;
			$cs->active_en = Input::has('active_en') ? 1 : 0;
			$cs->exhibition_pages()->save($exhibition_page);

	        return Redirect::action('ExhibitionPagesController@edit', ['id' => $exhibition_page->id]);
		}

		return Redirect::action('ContentSectionsController@index');
	}

	public function save() {
		$start_date = Input::get('start_date');
		if($start_date && strlen($start_date) > 0) {
			if(strpos($start_date, '/')) {
				$arr = explode('/', $start_date);
				$start_date = $arr[2].'-'.$arr[1].'-'.$arr[0];
			}
		}
		$end_date = Input::get('end_date');
		if($end_date && strlen($end_date) > 0) {
			if(strpos($end_date, '/')) {
				$arr = explode('/', $end_date);
				$end_date = $arr[2].'-'.$arr[1].'-'.$arr[0];
			}
		}

		if(!Input::has('id')) {
			$exhibition_page = new ExhibitionPage;
			$exhibition_page->page_type = 'exhibition';
		} else {
			$exhibition_page = Page::findOrFail(Input::get('id'));
		}

		$exhibition_page->title_de = Input::get('title_de');
		$exhibition_page->title_en = Input::get('title_en');
		$slug_de = strtolower(str_replace(' ', '-', Input::get('slug_de')));
		$slug_en = strtolower(str_replace(' ', '-', Input::get('slug_en')));
		$reps = [ 'ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue', 'Ä' => 'Ae', 'Ö' => 'Oe', 'Ü' => 'Ue', 'ß' => 'ss' ];
		foreach($reps as $char => $rep) {
			$slug_de = str_replace($char, $rep, $slug_de);
			$slug_en = str_replace($char, $rep, $slug_en);
		}
		$exhibition_page->slug_de = $slug_de;
		$exhibition_page->slug_en = $slug_en;
		$exhibition_page->seo_page_title_de = Input::get('seo_page_title_de');
		$exhibition_page->seo_page_title_en = Input::get('seo_page_title_en');
		$exhibition_page->seo_page_desc_de = Input::get('seo_page_desc_de');
		$exhibition_page->seo_page_desc_en = Input::get('seo_page_desc_en');
		$exhibition_page->start_date = $start_date;
		$exhibition_page->end_date = $end_date;
		$exhibition_page->active_de = Input::has('active_de') ? 1 : 0;
		$exhibition_page->active_en = Input::has('active_en') ? 1 : 0;
		$exhibition_page->cluster_id = Input::get('cluster_id');
		$exhibition_page->save();
		if(Input::has('contacts') && count(Input::get('contacts'))) {
			$exhibition_page->contacts()->sync(Input::get('contacts')); // attach contacts
		} else {
		    $exhibition_page->contacts()->detach(); // detatch contacts
		}
		if(Input::has('tags') && count(Input::get('tags'))) {
			$exhibition_page->tags()->sync(Input::get('tags')); // attach tags
		} else {
		    $exhibition_page->tags()->detach(); // detatch tags
		}

		return Redirect::action('ExhibitionPagesController@index');
	}

	public function storeSingleExhibitionPage()
	{
		if(Input::has('title_de')) {
			$exhibition_page = new ExhibitionPage;
			$exhibition_page->title_de = Input::get('title_de');
			$exhibition_page->title_en = Input::get('title_en');
			$exhibition_page->cluster_id = Input::get('cluster_id');
			$exhibition_page->active_de = Input::has('active_de') ? 1 : 0;
			$exhibition_page->active_en = Input::has('active_en') ? 1 : 0;
			$exhibition_page->save();
			if(Input::has('contacts') && count(Input::get('contacts'))) {
				$exhibition_page->contacts()->sync(Input::get('contacts')); // attach contacts
			} else {
			    $exhibition_page->contacts()->detach(); // detatch contacts
			}

			$cs = ContentSection::find(Input::get('cs_id'));
			$cs->title_de = Input::get('title_de');
			$cs->title_en = Input::get('title_en');
			$cs->active = Input::has('active_de') ? 1 : 0;
			$cs->save();

			$cs->exhibition_pages()->save($exhibition_page);

			$mi = MenuItem::find(Input::get('menu_item_id'));
			$mi->content_sections()->save($cs);

	        return Redirect::action('ExhibitionPagesController@edit', ['id' => $exhibition_page->id]);
		}

		return Redirect::action('ExhibitionPagesController@index');
	}

	public function edit($id, $action = null)
	{
		$exhibition_page = Page::with(['page_image_sliders', 'sponsor_groups', 'sponsor_groups.sponsors', 'downloads', 'cluster', 'banner', 'banner.banner_text', 'page_image_sliders.page_slider_images', 'image_grids', 'image_grids.grid_images', 'tags'])->findOrFail($id);
		$tags = Tag::all()->sortBy('tag_de');
		$_clusters = Cluster::all();
		$clusters = [];
		$cluster_match = false;
		foreach($_clusters as $c) {
			if($c->id == $exhibition_page->cluster_id) { $clusters[] = $c; $cluster_match = true; break; }
		}
		foreach($_clusters as $c) {
			if($c->id != $exhibition_page->cluster_id) { $clusters[] = $c; }
		}
		$_contacts = Contact::all();
		$contacts = [];
		$rel_contacts = [];
		$ids = [];
		foreach($exhibition_page->contacts as $c) { $rel_contacts[] = $c; $ids[] = $c->id; }
		foreach($_contacts as $c) {
			if(!in_array($c->id, $ids)) { $contacts[] = $c; }
		}
		$_sponsor_grps = SponsorGroup::all();
		$sponsor_grps = [];
		$rel_sponsor_grps = [];
		$ids = [];

		foreach($_clusters as $c) {
			if($c->id != $exhibition_page->cluster_id) { $clusters[] = $c; }
		}

		$sections = PagesController::getPageSections($id);

		$sort_limit = 1;
		$page_sections = DB::select('select count(id) as max_sort_order from page_sections where page_id = '. $id);
		if(is_array($page_sections) && count($page_sections)) {
			$sort_limit = $page_sections[0]->max_sort_order;
		}
		$rel_tags = [];
		foreach($exhibition_page->tags as $tag) {
			$rel_tags[] = $tag;
		}
		$downloads = $exhibition_page->downloads->toArray();
		usort($downloads, function($a, $b) {
			if($a['sort_order'] == $b['sort_order']) { return 0; }
			return $a['sort_order'] > $b['sort_order'] ? 1 : -1;
		});

		// if($exhibition_page->exhibition_page_contents) { $sort_limit += count($exhibition_page->exhibition_page_contents);	 }
		$params = [ 'page' => $exhibition_page, 'sort_limit' => $sort_limit, 'sections' => $sections, 'tags' => $tags, 'rel_tags' => $rel_tags,
					'DOMAIN' => $this->DOMAIN, 'clusters' => $clusters, 'cluster_match' => $cluster_match, 'rel_contacts' => $rel_contacts, 
					'contacts' => $contacts, 'downloads' => $downloads
				  ];
		$action_val = '';		  
		if(isset($action)) {
			$action_val = $action;
		}		  
		$params['action'] = $action_val;
		
		return View::make('pages.exhibition_pages.edit', $params);
	}

	public function update()
	{
		// echo 'update()<pre>'; print_r(Input::all()); exit;	
		$exhibition_page = Page::findOrFail(Input::get('id'));

		$exhibition_page->title_de = Input::get('title_de');
		$exhibition_page->title_en = Input::get('title_en');
		$slug_de = strtolower(str_replace(' ', '-', Input::get('slug_de')));
		$slug_en = strtolower(str_replace(' ', '-', Input::get('slug_en')));
		$reps = [ 'ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue', 'Ä' => 'Ae', 'Ö' => 'Oe', 'Ü' => 'Ue', 'ß' => 'ss' ];
		foreach($reps as $char => $rep) {
			$slug_de = str_replace($char, $rep, $slug_de);
			$slug_en = str_replace($char, $rep, $slug_en);
		}
		$exhibition_page->slug_de = $slug_de;
		$exhibition_page->slug_en = $slug_en;
		$exhibition_page->seo_page_title_de = Input::get('seo_page_title_de');
		$exhibition_page->seo_page_title_en = Input::get('seo_page_title_en');
		$exhibition_page->seo_page_desc_de = Input::get('seo_page_desc_de');
		$exhibition_page->seo_page_desc_en = Input::get('seo_page_desc_en');
		$exhibition_page->cluster_id = Input::get('cluster_id');
		if(Input::has('contacts') && count(Input::get('contacts'))) {
			$exhibition_page->contacts()->sync(Input::get('contacts')); // attach contacts
		} else {
		    $exhibition_page->contacts()->detach(); // detatch contacts
		}
		$exhibition_page->active_de = Input::has('active_de') ? 1 : 0;
		$exhibition_page->active_en = Input::has('active_en') ? 1 : 0;
		// $exhibition_page->sort_order = Input::get('sort_order');
		$exhibition_page->save();

		$cs = ContentSection::find(Input::get('cs_id'));
		if($cs->type == 'exhibition_page') {
			$cs->title_de = Input::get('title_de');
			$cs->title_en = Input::get('title_en');
			$cs->active = Input::has('active_de') ? 1 : 0;
			$cs->active_de = Input::has('active_de') ? 1 : 0;
			$cs->active_en = Input::has('active_en') ? 1 : 0;
			$cs->save();
		}

        return Redirect::action('ContentSectionsController@index', ['menu_item_id' => Input::get('menu_item_id')]);
	}

	public function saveDLProtection() {
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

		return Redirect::action('ExhibitionPagesController@edit', ['id' => Input::get('page_id')]);
	}

	public static function getExhibitionPageSections($exhibition_page_id = 0) {
		$sections = [];
		if($exhibition_page_id > 0) {
			$p_sections = ExhibitionPageSection::where('exhibition_page_id', $exhibition_page_id)->orderBy('sort_order')->get();
			if($p_sections != null && count($p_sections)) {
				foreach($p_sections as $ps) {
					$result = [];
					if($ps->content_id > 0) {
						$result = ExhibitionPageContent::find($ps->content_id);
						if(isset($result)) {
							$result->type = 'content';
						}
					} elseif($ps->gallery_id > 0) {
						$result = ExhibitionPageImageSlider::with('page_slider_images')->find($ps->gallery_id);
						if(isset($result)) {
							$result->type = 'slider';
						}	
					} elseif($ps->h2_id > 0) {
						$result = H2::find($ps->h2_id);
						if(isset($result)) {
							$result->type = 'h2';
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
		$sections = ExhibitionPagesController::getExhibitionPageSections($id);

		return View::make('pages.exhibition_pages.preview', ['sections' => $sections, 'menu_item_id' => $menu_item_id, 'cs_id' => $cs_id, 'exhibition_page_id' => $id]);
	}

	// public function __preview($cs_id, $id) {
	// 	$sections = ExhibitionPagesController::getExhibitionPageSections($id);

	// 	return View::make('pages.exhibition_pages.preview', ['sections' => $sections, 'cs_id' => $cs_id, 'exhibition_page_id' => $id]);		
	// }

	public function updateSectionExhibitionPage()
	{
		$exhibition_page = Page::findOrFail(Input::get('id'));

		$exhibition_page->title_de = Input::get('title_de');
		$exhibition_page->title_en = Input::get('title_en');
		$exhibition_page->active_de = Input::has('active_de') ? 1 : 0;
		$exhibition_page->active_en = Input::has('active_en') ? 1 : 0;
		$exhibition_page->sort_order = Input::get('sort_order');
		$exhibition_page->save();

		// $cs = ContentSection::find(Input::get('cs_id'));
		// $cs->save();

        return Redirect::action('ExhibitionPagesController@index', ['menu_item_id' => Input::get('menu_item_id'), 'cs_id' => Input::get('cs_id')]);
	}	

	public function destroy($id) {
		PageSection::where('page_id', $id)->delete();
		$sliders = PageImageSlider::where('page_id', $id)->get();
		foreach($sliders as $s) {
			PageSliderImage::where('page_image_slider_id', $s->id)->delete();
		}
		PageImageSlider::where('page_id', $id)->delete();
		Page::where('id', $id)->delete();

		return Redirect::action('ExhibitionPagesController@index');
	}

	public function test() {
		return View::make('pages.exhibition_pages.test');
	}

	public function deleteBanner() {
		if(Input::has('banner_id')) {
			Banner::where('id', Input::get('banner_id'))->delete();
		}

		return Response::json(array('error' => false), 200);
	}

	public function saveBanner() {
		// if(Request::ajax()) {
		$exhibition_page = Page::find(Input::get('id'));
		$new_image = false;
		$banner_img = '';
		if (Input::hasFile('banner_image')) {
			$new_image = true;
			$file = Input::file('banner_image');
			$banner_img = 'p'. str_replace(' ', '', strtolower($file->getClientOriginalName()));
    		$file->move('files/exhibition_pages/', $banner_img);
    	}	

		if(intval(Input::get('banner_id')) == 0) {
    		$banner = new Banner();
    		if($new_image) {
    			$banner->image = $banner_img;
    		}
    		$banner->page_id = $exhibition_page->id;
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
    		$exhibition_page->banner()->save($banner);

		} else {
    		
    		$banner = Banner::with('banner_text')->find(Input::get('banner_id'));
    		if($new_image) {
    			$banner->image = $banner_img;
    		}
    		$banner->text_position = Input::get('position');
			$banner->save();
    		$exhibition_page->banner()->save($banner);				
	        return Redirect::action('ExhibitionPagesController@edit', ['id' => $exhibition_page->id, 'action' => 'banner']);
		}

        return Redirect::action('ExhibitionPagesController@edit', ['id' => Input::get('id'), 'action' => 'banner']);
	}

	public function uploadExhibitionPageImage() {
		if(Request::ajax()) {
			if (Input::hasFile('banner_image')) {
				$file = Input::file('banner_image');
				$img = strtolower($file->getClientOriginalName());
	    		$file->move('files/exhibition_pages/', $img);
	    		$preivew = '/files/exhibition_pages/' . $img;

				return Response::json(array('error' => false, 'preivew' => $preivew), 200);
			}
		}

		return Response::json(array('error' => true, 'message' => 'Error processing image'), 422);
	}

	public function getBanner() {
		$banner = Banner::with(['banner_text'])->find(Input::get('id'));

		return Response::json(array('error' => false, 'banner' => $banner), 200);
	}

	public function deleteExhibitionPageBanner($banner_id, $menu_item_id, $cs_id, $id) {
		$exhibition_page = Page::find($id);
		Banner::where('id', $banner_id)->delete();

        return Redirect::action('ExhibitionPagesController@edit', ['menu_item_id' => $menu_item_id, 'cs_id' => $cs_id, 'id' => $id]);
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

	public function deleteExhibitionPageImage() {
		if(Request::ajax()) {
    		$exhibition_page = Page::find(Input::get('id'));
    		$exhibition_page->exhibition_page_image = '';
    		$exhibition_page->save();

			return Response::json(array('error' => false, 'exhibition_page' => $exhibition_page), 200);
		}

		return Response::json(array('error' => true, 'message' => 'Error processing saveExhibitionPageImage()'), 422);
	}	
	
}
