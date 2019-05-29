<?php

class FooterPagesController extends BaseController {

	var $DOMAIN = '';

	public function __construct() {
		$this->DOMAIN = 'http://'. $_SERVER['SERVER_NAME'];
	}

	public function index()
	{
		$footer_pages = [];
		$footer_pages = Page::with('page_image_sliders')
								 ->where('page_type', 'footer')
								 ->get();	
		// echo '<pre>'; print_r($footer_pages); exit;

		return View::make('pages.footer_pages.index', ['pages' => $footer_pages]);
	}

	public function show()
	{
		// $events = Event::all();	

		return View::make('pages.footer_pages.index');//, ['events' => ['apples', 'oranges', 'mangoes'] ] ); // $events] );
	}

	public function create()
	{
		$pages = Page::where('page_type', 'footer')->get();
		$count = count($pages);
		if($count == 0) { $count = 1; } else { ++$count; }

		return View::make('pages.footer_pages.create', ['page_count' => $count]);
	}

	public function store()
	{
		// echo 'update()<pre>'; print_r(Input::all()); exit;
		$page = new Page();
		$page->title_de = Input::get('title_de');
		$page->title_en = Input::get('title_en');
		$page->slug_de = Input::get('slug_de');
		$page->slug_en = Input::get('slug_en');
		$page->seo_page_title_de = Input::get('seo_page_title_de');
		$page->seo_page_title_en = Input::get('seo_page_title_en');
		$page->seo_page_desc_de = Input::get('seo_page_desc_de');
		$page->seo_page_desc_en = Input::get('seo_page_desc_en');
		$page->sort_order = Input::get('sort_order');
		$page->active_de = Input::has('active_de') ? 1 : 0;
		$page->active_en = Input::has('active_en') ? 1 : 0;
		$page->page_type = 'footer';
		$page->save();

		$pc = new PageContent();
		$pc->page_id = $page->id;
		$pc->save();

		return Redirect::action('FooterPagesController@edit', ['id' => $page->id]);
	}

	public function edit($id, $action = null)
	{
		$page = Page::with(['page_contents'])->findOrFail($id);
		$pages = Page::where('page_type', 'footer')->get();
		$count = count($pages);

		$params = [ 'page' => $page, 'page_count' => $count];

		return View::make('pages.footer_pages.edit', $params);
	}

	public function update()
	{
		// echo 'update()<pre>'; print_r(Input::all()); exit;
		$page = Page::findOrFail(Input::get('id'));
		$page->title_de = Input::get('title_de');
		$page->title_en = Input::get('title_en');
		$page->slug_de = Input::get('slug_de');
		$page->slug_en = Input::get('slug_en');
		$page->seo_page_title_de = Input::get('seo_page_title_de');
		$page->seo_page_title_en = Input::get('seo_page_title_en');
		$page->seo_page_desc_de = Input::get('seo_page_desc_de');
		$page->seo_page_desc_en = Input::get('seo_page_desc_en');
		$page->sort_order = Input::get('sort_order');
		$page->active_de = Input::has('active_de') ? 1 : 0;
		$page->active_en = Input::has('active_en') ? 1 : 0;
		$page->save();

		$pc = PageContent::where('page_id', $page->id)->first();
		$pc->content_de = Input::get('content_de');
		$pc->content_en = Input::get('content_en');
		$pc->save();

        return Redirect::action('FooterPagesController@edit', ['id' => $page->id]);
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

		return Redirect::action('FooterPagesController@edit', ['id' => Input::get('page_id')]);
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
	
	public static function getFooterPageSections($footer_page_id = 0) {
		$sections = [];
		if($footer_page_id > 0) {
			$p_sections = FooterPageSection::where('footer_page_id', $footer_page_id)->orderBy('sort_order')->get();
			if($p_sections != null && count($p_sections)) {
				foreach($p_sections as $ps) {
					$result = [];
					if($ps->content_id > 0) {
						$result = FooterPageContent::find($ps->content_id);
						if(isset($result)) {
							$result->type = 'content';
						}
					} elseif($ps->gallery_id > 0) {
						$result = FooterPageImageSlider::with('page_slider_images')->find($ps->gallery_id);
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
		$sections = FooterPagesController::getFooterPageSections($id);

		return View::make('pages.footer_pages.preview', ['sections' => $sections, 'menu_item_id' => $menu_item_id, 'cs_id' => $cs_id, 'footer_page_id' => $id]);
	}

	// public function __preview($cs_id, $id) {
	// 	$sections = FooterPagesController::getFooterPageSections($id);

	// 	return View::make('pages.footer_pages.preview', ['sections' => $sections, 'cs_id' => $cs_id, 'footer_page_id' => $id]);		
	// }

	public function updateSectionFooterPage()
	{
		$footer_page = Page::findOrFail(Input::get('id'));

		$footer_page->title_de = Input::get('title_de');
		$footer_page->title_en = Input::get('title_en');
		$footer_page->sort_order = Input::get('sort_order');
		$footer_page->save();

		// $cs = ContentSection::find(Input::get('cs_id'));
		// $cs->save();

        return Redirect::action('FooterPagesController@index', ['menu_item_id' => Input::get('menu_item_id'), 'cs_id' => Input::get('cs_id')]);
	}	

	public function destroy($id) {
		PageSection::where('page_id', $id)->delete();
		$sliders = PageImageSlider::where('page_id', $id)->get();
		foreach($sliders as $s) {
			PageSliderImage::where('page_image_slider_id', $s->id)->delete();
		}
		PageImageSlider::where('page_id', $id)->delete();
		Page::where('id', $id)->delete();

		return Redirect::action('FooterPagesController@index');
	}

	public function test() {
		return View::make('pages.footer_pages.test');
	}

	public function deleteBanner() {
		if(Input::has('banner_id')) {
			Banner::where('id', Input::get('banner_id'))->delete();
		}

		return Response::json(array('error' => false), 200);
	}

	public function saveBanner() {
		// echo '<pre>'; print_r(Input::all()); //exit;
		// if(Request::ajax()) {
		$footer_page = Page::find(Input::get('id'));
		$new_image = false;
		$banner_img = '';
		if (Input::hasFile('banner_image')) {
			$new_image = true;
			$file = Input::file('banner_image');
			$banner_img = 'p'. str_replace(' ', '', strtolower($file->getClientOriginalName()));
    		$file->move('files/footer_pages/', $banner_img);
    	}	

		if(intval(Input::get('banner_id')) == 0) {
    		$banner = new Banner();
    		if($new_image) {
    			$banner->image = $banner_img;
    		}
    		$banner->page_id = $footer_page->id;
    		$banner->save();	

    		$text = new BannerText();
    		for($n=1; $n<20; $n++) {
	    		if(Input::has('line_'.$n) && strlen(trim(Input::get('line_'.$n))) > 0) {
		    		$text::insert(['banner_id' => $banner->id, 
		    			  'line' => Input::get('line_'.$n), 'size' => Input::get('line_'.$n.'_size'),
		    			]);
	    		}    		
    		}
    		$footer_page->banner()->save($banner);

		} else {
    		
    		$banner = Banner::with('banner_text')->find(Input::get('banner_id'));
    		if($new_image) {
    			$banner->image = $banner_img;
    		}
			$banner->save();
    		$footer_page->banner()->save($banner);				
	        return Redirect::action('FooterPagesController@edit', ['id' => $footer_page->id, 'action' => 'banner']);
		}

        return Redirect::action('FooterPagesController@edit', ['id' => Input::get('id')]);
	}

	public function uploadFooterPageImage() {
		if(Request::ajax()) {
			if (Input::hasFile('banner_image')) {
				$file = Input::file('banner_image');
				$img = strtolower($file->getClientOriginalName());
	    		$file->move('files/footer_pages/', $img);
	    		$preivew = '/files/footer_pages/' . $img;

				return Response::json(array('error' => false, 'preivew' => $preivew), 200);
			}
		}

		return Response::json(array('error' => true, 'message' => 'Error processing image'), 422);
	}

	public function getBanner() {
		$banner = Banner::with(['banner_text'])->find(Input::get('id'));

		return Response::json(array('error' => false, 'banner' => $banner), 200);
	}

	public function deleteFooterPageBanner($banner_id, $menu_item_id, $cs_id, $id) {
		$footer_page = Page::find($id);
		Banner::where('id', $banner_id)->delete();

        return Redirect::action('FooterPagesController@edit', ['menu_item_id' => $menu_item_id, 'cs_id' => $cs_id, 'id' => $id]);
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
						   'line' => Input::get('line'),
			               'size' => Input::get('size')]);
			$text = BannerText::find($id);
		} else {
			BannerText::where('id', Input::get('id'))
			    ->update(['line' => Input::get('line'), 'size' => Input::get('size')]);
			$text = BannerText::find(Input::get('id'));
		}

		return Response::json(array('error' => false, 'text' => $text), 200);
	}

	public function deleteFooterPageImage() {
		if(Request::ajax()) {
    		$footer_page = Page::find(Input::get('id'));
    		$footer_page->footer_page_image = '';
    		$footer_page->save();

			return Response::json(array('error' => false, 'footer_page' => $footer_page), 200);
		}

		return Response::json(array('error' => true, 'message' => 'Error processing saveFooterPageImage()'), 422);
	}	
	
}
