<?php

class PagesController extends BaseController {

	var $DOMAIN = '';

	public function __construct() {
		$this->DOMAIN = 'http://'. $_SERVER['SERVER_NAME'];
	}

	public function index($cs_id)
	{
		$pages = Page::with('page_image_sliders')->where('content_section_id', $cs_id)->get();	
		// echo '<pre>'; print_r($pages); exit;
		return View::make('pages.pages.index', ['pages' => $pages, 'cs_id' => $cs_id]);
	}

	public function show()
	{
		// $events = Event::all();	

		return View::make('pages.pages.index');//, ['events' => ['apples', 'oranges', 'mangoes'] ] ); // $events] );
	}

	public function createSectionPage($cs_id)
	{
		return View::make('pages.pages.create-sp', ['cs_id' => $cs_id]);
	}

	public function storeSectionPage()
	{
		if(Input::has('cs_id')) {
			$page = new Page;
			$page->title_de = Input::get('title_de');
			$page->title_en = Input::get('title_en');
			$page->save();

			$cs = ContentSection::find(Input::get('cs_id'));
			$cs->pages()->save($page);

	        return Redirect::action('PagesController@edit', ['cs_id' => Input::get('cs_id'), 'id' => $page->id]);
		}

		return Redirect::action('ContentSectionsController@index');
	}

	public function create()
	{
		return View::make('pages.pages.create');
	}

	public function store()
	{
		if(Input::has('title_de')) {
			$page = new Page;
			$page->title_de = Input::get('title_de');
			$page->title_en = Input::get('title_en');
			$page->save();

	        return Redirect::action('PagesController@edit', ['cs_id' => Input::get('cs_id'), 'id' => $page->id]);
		}

		return Redirect::action('ContentSectionsController@index');
	}

	public function editSectionPage($cs_id, $id)
	{
		$page = Page::with(['page_contents', 'page_image_sliders', 'page_image_sliders.page_slider_images'])->findOrFail($id);
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

		
		return View::make('pages.pages.edit-sp', [ 'page' => $page, 'sections' => $sections, 'content_section' => $content_section, 
						'cs_id' => $cs_id, 'DOMAIN' => $this->DOMAIN, 'sort_limit' => $sort_limit, 'page_count' =>$page_count ]);
	}

	public function edit($cs_id, $id)
	{
		$page = Page::with(['page_contents', 'page_image_sliders', 'page_image_sliders.page_slider_images'])->findOrFail($id);
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

		
		return View::make('pages.pages.edit', [ 'page' => $page, 'sections' => $sections, 'content_section' => $content_section, 
						'cs_id' => $cs_id, 'DOMAIN' => $this->DOMAIN, 'sort_limit' => $sort_limit, 'page_count' =>$page_count ]);
	}

	public static function getPageSections($page_id = 0) {
		$sections = [];
		if($page_id > 0) {
			$p_sections = PageSection::where('page_id', $page_id)->orderBy('sort_order')->get();
			if($p_sections && count($p_sections)) {
				foreach($p_sections as $ps) {
					$result = [];
					if($ps->content_id > 0) {
						$result = PageContent::find($ps->content_id);
						$result->type = 'content';
					} elseif($ps->gallery_id > 0) {
						$result = PageImageSlider::with('page_slider_images')->find($ps->gallery_id);
						$result->type = 'slider';
					}
					$sections[] = $result;
				}
			}
		}

		return $sections;		
	}

	public function preview($cs_id, $id) {
		$sections = PagesController::getPageSections($id);

		return View::make('pages.pages.preview', ['sections' => $sections, 'cs_id' => $cs_id, 'page_id' => $id]);		
	}

	public function update()
	{
		$page = Page::findOrFail(Input::get('id'));

		$page->title_de = Input::get('title_de');
		$page->title_en = Input::get('title_en');
		$page->sort_order = Input::get('sort_order');
		$page->save();

        return Redirect::action('ContentSectionsController@index');
	}

	public function updateSectionPage()
	{
		$page = Page::findOrFail(Input::get('id'));

		$page->title_de = Input::get('title_de');
		$page->title_en = Input::get('title_en');
		$page->sort_order = Input::get('sort_order');
		$page->save();

		$cs = ContentSection::find(Input::get('cs_id'));
		$cs->pages()->save($page);

        return Redirect::action('PagesController@index', ['cs_id' => Input::get('cs_id')]);
	}	
	public function destroy($cs_id, $id) {
		PageSection::where('page_id', $id)->delete();
		PageContent::where('page_id', $id)->delete();
		$sliders = PageImageSlider::where('page_id', $id)->get();
		foreach($sliders as $s) {
			PageSliderImage::where('page_image_slider_id', $s->id)->delete();
		}
		PageImageSlider::where('page_id', $id)->delete();
		Page::where('id', $id)->delete();

		return Redirect::action('PagesController@index', ['cs_id' => $cs_id]);
	}

	public function test() {
		return View::make('pages.pages.test');
	}

	public function savePageImage() {
		if(Request::ajax()) {
			if (Input::hasFile('page_image')) {
				$file = Input::file('page_image');
				$img = 'p'. str_replace(' ', '', strtolower($file->getClientOriginalName()));
	    		$file->move('files/pages/', $img);

	    		$page = Page::find(Input::get('id'));
	    		$page->page_image = $img;
	    		$page->save();

				return Response::json(array('error' => false, 'page' => $page), 200);
			}
		}

		return Response::json(array('error' => true, 'message' => 'Error processing savePageImage()'), 422);
	}

	public function uploadPageImage() {
		if(Request::ajax()) {
			if (Input::hasFile('page_image')) {
				$file = Input::file('page_image');
				$img = strtolower($file->getClientOriginalName());
	    		$file->move('files/pages/', $img);
	    		$preivew = '/files/pages/' . $img;

				return Response::json(array('error' => false, 'preivew' => $preivew), 200);
			}
		}

		return Response::json(array('error' => true, 'message' => 'Error processing image'), 422);
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
	
}
