<?php

class PageImageSlidersExbController extends BaseController {

	public function index($page_id)
	{
		$sliders = PageImageSlider::all();	
		// echo '<pre>'; print_r($content_sections); exit;
		return View::make('pages.contents.index', ['sliders' => $sliders, 'page_id' => $page_id]);
	}

	public function createSlider() {
		if(Input::has('id')) {
			$sls = PageImageSlider::where('page_id', Input::get('id'))->get();
			$title = 'slider';
			$sl = new PageImageSlider();
			$sl->title = $title;
			$sl->page_id = Input::get('id');
			$sl->save();

			return Response::json(array('error' => false, 'item' => $sl), 200);
		}

		return Response::json(array('error' => true, 'message' => 'Error processing request'), 422);
	}

	public function deleteSlider() {
		if(Input::has('id')) {
			PageImageSlider::where('id', Input::get('id'))->delete();

			return Response::json(array('error' => false, 'msg' => 'deleted'), 200);
		}

		return Response::json(array('error' => true, 'message' => 'Error processing request'), 422);
	}

	public function store() {
		if(Input::has('page_id')) {	
			$max_sort_order = 1;
			$page_sections = DB::select('select max(sort_order)+1 as max_sort_order from page_sections where page_id = '. Input::get('page_id'));
			if(is_array($page_sections) && count($page_sections)) {
				if($page_sections[0]->max_sort_order != null && is_numeric($page_sections[0]->max_sort_order)) {
					$max_sort_order = $page_sections[0]->max_sort_order;
				}
			}
			$pis_res = DB::select('select max(sort_order) as max_order from page_image_sliders where page_id = '. Input::get('page_id'));			
			$order = 1;
			if($pis_res) {
				$order = $pis_res[0]->max_order + 1;
			}

			$slider = new PageImageSlider();
			$slider->title = Input::get('');
			$slider->sort_order = $order;
			$slider->save();

			$page = Page::find(Input::get('page_id'));
			$page->page_image_sliders()->save($slider);


			PageSection::insert(['page_id' => $page->id, 'gallery_id' => $slider->id, 'sort_order' => $max_sort_order]);

			return Redirect::action('ExhibitionPagesController@edit', ['id' => Input::get('page_id'), 'action'=>'new_slider']);
		}	

		return Redirect::action('ExhibitionPagesController@edit', ['id' => Input::get('page_id')]);
	}

	public function createNewSlider() {
		if(Input::has('page_id')) {	
			$max_sort_order = 1;
			$page_sections = DB::select('select max(sort_order)+1 as max_sort_order from page_sections where page_id = '. Input::get('page_id'));
			if(is_array($page_sections) && count($page_sections)) {
				if($page_sections[0]->max_sort_order != null && is_numeric($page_sections[0]->max_sort_order)) {
					$max_sort_order = $page_sections[0]->max_sort_order;
				}
			}
			$slider = new PageImageSlider();
			$slider->title = Input::get('');
			// $slider->sort_order = Input::has('sort_order') ? Input::get('sort_order') : $max_sort_order;
			$slider->save();

			$page = Page::find(Input::get('page_id'));
			$page->page_image_sliders()->save($slider);

			PageSection::insert(['page_id' => $page->id, 'gallery_id' => $slider->id, 'sort_order' => $max_sort_order]);

			return Response::json(array('error' => false, 'item' => $slider), 200);
		}

		return Response::json(array('error' => true, 'message' => 'Error processing request'), 422);
	}

	public function storeAjx() {
		if(Input::has('page_id')) {	
			$max_sort_order = 1;
			$page_sections = DB::select('select max(sort_order)+1 as max_sort_order from page_sections where page_id = '. Input::get('page_id'));
			if(is_array($page_sections) && count($page_sections)) {
				if($page_sections[0]->max_sort_order != null && is_numeric($page_sections[0]->max_sort_order)) {
					$max_sort_order = $page_sections[0]->max_sort_order;
				}
			}
			$slider = new PageImageSlider();
			$slider->title = Input::get('title');
			$slider->sort_order = Input::has('sort_order') ? Input::get('sort_order') : $max_sort_order;
			$slider->save();

			// // $page_sections = DB::select('select count(id)+1 as max_sort_order from page_sections where page_id = '. $page->id);
			// if(is_array($page_sections) && count($page_sections)) {
			// 	$max_sort_order = $page_sections[0]->max_sort_order;
			// }
			PageSection::insert(['page_id' => $page->id, 'gallery_id' => $slider->id, 'sort_order' => $max_sort_order]);

			$page = Page::find(Input::get('page_id'));
			$page->page_image_sliders()->save($slider);

			return Response::json(array('error' => false, 'page' => $page), 200);
		}

		return Response::json(array('error' => true, 'message' => 'Error processing request'), 422);
	}

	public function updateAjx() {
		if(Input::has('page_id')) {	
			$slider = PageImageSlider::find(Input::get('id'));
			$slider->title = Input::get('title');
			$slider->sort_order = Input::get('sort_order');
			$slider->save();

			PageSectionsController::adjustSortOrder(Input::get('page_id'), $slider->id, 'gallery', Input::get('sort_order'));

			$page = Page::find(Input::get('page_id'));
			$page->page_image_sliders()->save($slider);

			$sections = PagesController::getPageSections(Input::get('page_id'));

			return Response::json(array('error' => false, 'page' => $page, 'sections' => $sections), 200);
		}

		return Response::json(array('error' => true, 'message' => 'Error processing request'), 422);
	}
}