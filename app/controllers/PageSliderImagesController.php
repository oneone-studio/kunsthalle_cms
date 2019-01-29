<?php

class PageSliderImagesController extends BaseController {

	public function index($page_id, $slider_id)
	{
		$sliders = PageSliderImage::where('page_image_slider_id', $slider_id)->get();	
		// echo '<pre>'; print_r($sliders); exit;
		return View::make('pages.contents.index', ['sliders' => $sliders, 'page_id' => $page_id]);
	}

	public function store() {
		$input = Input::all();
		// echo '<pre>'; print_r($input); exit;

		// $content = new Content();
		// $content->content_de = Input::get('content_de');
		// $content->content_en = Input::get('content_en');
		// $content->save();

        return Redirect::action('ContentsController@index', ['page_id' => Input::get('page_id')]);
	}

	public function savePageSliderImage() {
		if(Request::ajax()) {
			if (Input::hasFile('gallery_image')) {

	    		$slider = PageImageSlider::with(['page_slider_images'])->find(Input::get('slider_id'));
	    		$order = 1;
	    		if($slider->page_slider_images) {
	    			foreach($slider->page_slider_images as $img) {
	    				$img->sort_order = $img->sort_order + 1;
	    				$img->save();
	    			}
	    		}
	    		// $order = Input::has('sort_order') ? Input::get('sort_order') : $order;
				$file = Input::file('gallery_image');
	    		$file->move('images/gallery/', $file->getClientOriginalName());

	    		$image = new PageSliderImage();
	    		$image->filename = $file->getClientOriginalName();
	    		$image->path = '/sliders/';
	    		$image->page_image_slider_id = Input::get('slider_id');
	    		if(Input::has('image_detail')) {
		    		$image->detail = Input::get('image_detail');
	    		}
	    		$image->url = Input::get('url');
	    		$image->text_position = Input::get('position');
	    		$image->sort_order = 1;
	    		$image->save();

	    		$slider->page_slider_images()->save($image);
	    		$slider = PageImageSlider::with('page_slider_images')->find(Input::get('slider_id'));
	    		$images = $slider->page_slider_images;
	    		// $images = PageSliderImage::where('page_image_slider_id', Input::get('slider_id'))->get()->sortBy('sort_order');

				return Response::json(array('error' => false, 'images' => $images), 200);
			}
		}

		return Response::json(array('error' => true, 'message' => 'Error creating product'), 422);
	}

	public function editPageSliderImage() {
		
		if(Request::ajax()) {
			if(Input::has('id')) {
				$image = PageSliderImage::find(Input::get('id'));

				return Response::json(array('error' => false, 'item' => $image), 200);
			}
		}

		return Response::json(array('error' => true, 'message' => 'Error creating product'), 422);
	}

	public function upload() {
		if(Request::ajax()) {
			if (Input::hasFile('gallery_image')) {
				$file = Input::file('gallery_image');
	    		$file->move('files/sliders/', $file->getClientOriginalName());
	    		$preivew = '/files/sliders/' . $file->getClientOriginalName();

				return Response::json(array('error' => false, 'preivew' => $preivew), 200);
			}
		}

		return Response::json(array('error' => true, 'message' => 'Error processing image'), 422);
	}

	public function getPageSliderImage() {
		if(Request::ajax()) {
			if(Input::has('id')) {
				$image = PageSliderImage::with('slide_text')->find(Input::get('id'));

				return Response::json(array('error' => false, 'image' => $image), 200);
			}
		}

		return Response::json(array('error' => true, 'message' => 'Error processing request'), 422);
	}

	public function updatePageSliderImage() {
		$f = fopen('test.log', 'w+');
		fwrite($f, "updatePageSliderImage..\n\n". print_r(Input::all(), true));
		if(Request::ajax()) {
			if(Input::has('image_id') || Input::has('slide_id')) {
	    // 		if(Input::has('sort_order')) {
	    // 			$img = PageSliderImage::find(Input::get('slide_id'));
					// fwrite($f, "\nimg:\nid: ". $img->id . ' __ order: '. $img->sort_order);
	    // 			if($img) { 
	    // 				$old_order = $img->sort_order;
	    // 				fwrite($f, "\nold order: ". $old_order);
	    // 				$img2 = PageSliderImage::where('page_image_slider_id', Input::get('slider_id'))
	    // 						->where('sort_order', Input::get('sort_order'))
	    // 						->first();
    	// 				fwrite($f, "\n\nBefore img2:\nid: ". $img2->id . ' __ order: '. $img2->sort_order);
	    // 				if($img2) { 
	    // 					$img2->sort_order = $old_order;
	    // 					$img2->save();
	    // 					fwrite($f, "\n\nAfter img2:\nid: ". $img2->id . ' __ order: '. $img2->sort_order);
	    // 				}	    				
	    // 			} 
	    // 		}

				$image_id = Input::has('image_id') ? Input::get('image_id') : Input::get('slide_id');
				$filename = '';
				if(Input::hasFile('gallery_image')) {
					$file = Input::file('gallery_image');
					$filename = $file->getClientOriginalName();
					$file = Input::file('gallery_image');
		    		$file->move('files/sliders/', $filename);
				}
				$image = PageSliderImage::find($image_id);

				if(strlen($filename) > 0) {
		    		$image->filename = $filename;
				}
	    		if(Input::has('image_detail')) {
		    		$image->detail = Input::get('image_detail');
	    		}
	    		$image->url = Input::get('url');
	    		$image->text_position = Input::get('position');
	    		$image->sort_order = Input::get('sort_order');
	    		$image->save();


	    		$slider = PageImageSlider::with(['page_slider_images'])->find(Input::get('slider_id'));

				return Response::json(array('error' => false, 'item' => $image, 'slider' => $slider), 200);
			}
		}

		return Response::json(array('error' => true, 'message' => 'Error creating product'), 422);
	}

	public function setSlideOrder($id, $order) {
		if($id && $order && is_numeric($id) && is_numeric($order)) {
			$slide = PageSliderImage::find($id);
			if($slide) {
				$slide->sort_order = $order;
				$slide->save();
			}
		}

		return Redirect::action('PagesController@editStartPage');
	}

	public function deletePageSliderImage() {
		
		if(Request::ajax()) {
			if(Input::has('id')) {
				$img = PageSliderImage::find(Input::get('id'));
				$img->delete();

				return Response::json(array('error' => false, 'item' => Input::get('id')), 200);
			}
		}

		return Response::json(array('error' => true, 'message' => 'Error creating product'), 422);
	}
}