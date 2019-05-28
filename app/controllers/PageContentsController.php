<?php

class PageContentsController extends BaseController {

	public function index($page_id)
	{
		$contents = PageContent::all();	
		// echo '<pre>'; print_r($content_sections); exit;
		return View::make('pages.contents.index', ['contents' => $contents, 'page_id' => $page_id]);
	}

	public function store() {
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('http://www.google.com');
		}
		$input = Input::all();
		// echo '<pre>'; print_r($input); exit;

		if(Input::has('id')) {
			$max_sort_order = 1;
			$page_sections = DB::select('select max(sort_order)+1 as max_sort_order from page_sections where page_id = '. Input::get('id'));
			if(is_array($page_sections) && count($page_sections)) {
				if($page_sections[0]->max_sort_order != null && is_numeric($page_sections[0]->max_sort_order)) {
					$max_sort_order = $page_sections[0]->max_sort_order;
				}
			}
			$content = new PageContent();
			$content->title_de = Input::get('title_de');
			$content->title_en = Input::get('title_en');
			$content->subtitle_de = Input::get('subtitle_de');
			$content->subtitle_en = Input::get('subtitle_en');
			$content->content_de = Input::get('content_de');
			$content->content_en = Input::get('content_en');
			$content->sort_order = $max_sort_order;
			$content->save();

			$page = Page::find(Input::get('id'));
			$page->page_contents()->save($content);

			PageSection::insert(['page_id' => $page->id, 'content_id' => $content->id, 'sort_order' => $max_sort_order]);
		}

        return Redirect::action('PagesController@edit', ['menu_item_id' => Input::get('menu_item_id'), 'cs_id' => Input::get('cs_id'), 'id' => Input::get('id')]);
	}

	public function save() {
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('http://www.google.com');
		}
		if(Input::has('pc_id') && intval(Input::get('pc_id')) > 0) {
			$content = PageContent::find(Input::get('pc_id'));
			$content->content_de = Input::get('content_de');
			$content->content_en = Input::get('content_en');
			$content->anchor_title_de = Input::get('anchor_title_de');
			$content->anchor_title_en = Input::get('anchor_title_en');
			// $content->sort_order = Input::get('sort_order');
			$content->save();
		} else {
			$max_sort_order = 1;
			$page_sections = DB::select('select max(sort_order)+1 as max_sort_order from page_sections where page_id = '. Input::get('id'));
			if(is_array($page_sections) && count($page_sections)) {
				if($page_sections[0]->max_sort_order != null && is_numeric($page_sections[0]->max_sort_order)) {
					$max_sort_order = $page_sections[0]->max_sort_order;
				}
			}
			$max_sort_order = 1;
			$page_sections = DB::select('select max(sort_order)+1 as max_sort_order from page_sections where page_id = '. Input::get('id'));
			if(is_array($page_sections) && count($page_sections)) {
				if($page_sections[0]->max_sort_order != null && is_numeric($page_sections[0]->max_sort_order)) {
					$max_sort_order = $page_sections[0]->max_sort_order;
				}
			}
			$content = new PageContent();
			$content->content_de = Input::get('content_de');
			$content->content_en = Input::get('content_en');
			$content->anchor_title_de = Input::get('anchor_title_de');
			$content->anchor_title_en = Input::get('anchor_title_en');
			$content->sort_order = $max_sort_order;
			$content->save();

			$page = Page::find(Input::get('id'));
			$page->page_contents()->save($content);

			PageSection::insert(['page_id' => $page->id, 'content_id' => $content->id, 'sort_order' => $max_sort_order]);
		}

		return Redirect::action('PagesController@edit', ['menu_item_id' => Input::get('menu_item_id'), 'cs_id' => Input::get('cs_id'), 'id' => Input::get('id')]);
	}

	public function getPageContent() {
		if(Input::has('id')) {
			$content = PageContent::find(Input::get('id'));
			$sort_limit = 0;
			$page = Page::with(['page_image_sliders', 'page_contents'])->find(Input::get('page_id'));
			if($page) {
				$sort_limit = count($page->page_image_sliders) + count($page->page_contents);
			}

			return Response::json(array('error' => false, 'item' => $content, 'sort_limit' => $sort_limit), 200);
		}

		return Response::json(array('error' => true, 'message' => 'Error processing request'), 422);
	}

	public function updatePageContent() {
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('http://www.google.com');
		}
		if(Input::has('id')) {
			$content = PageContent::find(Input::get('id'));
			$content->title_de = Input::get('title_de');
			$content->title_en = Input::get('title_en');
			$content->subtitle_de = Input::get('subtitle_de');
			$content->subtitle_en = Input::get('subtitle_en');
			$content->content_de = Input::get('content_de');
			$content->content_en = Input::get('content_en');
			$content->sort_order = Input::get('sort_order');
			$content->save();

			PageSectionsController::adjustSortOrder(Input::get('page_id'), $content->id, 'content', Input::get('sort_order'));

			$page = Page::with('page_contents')->find(Input::get('page_id'));

			$sections = PagesController::getPageSections(Input::get('page_id'));

			return Response::json(array('error' => false, 'item' => $content, 'sections' => $sections, 'page' => $page), 200);
		}

		return Response::json(array('error' => true, 'message' => 'Error processing request'), 422);
	}

	public function deletePageContent() {
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('http://www.google.com');
		}
		if(Input::has('id')) {
			PageContent::where('id', Input::get('id'))->delete();
			PageSection::where('page_id', Input::get('page_id'))
					   ->where('content_id', Input::get('id'))->delete();

			return Response::json(array('error' => false, 'msg' => 'Item deleted'), 200);
		}

		return Response::json(array('error' => true, 'message' => 'Error processing request'), 422);
	}
}
















