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

        return Redirect::action('ContentsController@index', ['page_id' => Input::get('page_id')]);
	}

	public function savePageSliderImage() {
		$f = fopen('logs/cms.log', 'w+');
		fwrite($f, "savePageSliderImage() [".date('Y-m-d H:i')."]..\n\n".print_r(Input::all(), true));
		if(Request::ajax()) {
			$update = false;
    		$slider = PageImageSlider::with(['page_slider_images'])->find(Input::get('slider_id'));
    		$image = null;
    		if(Input::has('slider_image_id') && Input::get('slider_image_id') > 0) {
				$image = PageSliderImage::find(Input::get('slider_image_id'));
				$update = true;
    		} else {
	    		$image = new PageSliderImage();
	    		$order = 1;
	    		if(isset($slider->page_slider_images)) {
	    			foreach($slider->page_slider_images as $img) {
	    				$img->sort_order = $img->sort_order + 1;
	    				$img->save();
	    			}
	    		}
    		}
    		// $order = Input::has('sort_order') ? Input::get('sort_order') : $order;
    		if (Input::hasFile('gallery_image')) {
				$file = Input::file('gallery_image');
	    		$file->move('images/gallery/', $file->getClientOriginalName());
	    		$image->filename = $file->getClientOriginalName();
	    		$image->path = '/sliders/';
	    	}	
    		$image->page_image_slider_id = Input::get('slider_id');
    		if(Input::has('image_detail_de')) {
	    		$image->detail_de = Input::get('image_detail_de');
	    		$image->detail_en = Input::get('image_detail_en');
    		}
    		$image->url_de = Input::get('url_de');
    		$image->url_en = Input::get('url_en');
    		$image->active_de = Input::has('active_de') ? 1 : 0;
    		$image->active_en = Input::has('active_en') ? 1 : 0;
    		$image->text_position = Input::get('position');
    		if($update) {
	    		$image->sort_order = Input::has('sort_order') ? Input::get('sort_order') : 1;
    		} else {
    			$image->sort_order = 1;
    		}
    		$image->save();

    		$slider->page_slider_images()->save($image);
    		$slider = PageImageSlider::with('page_slider_images')->find(Input::get('slider_id'));
    		$images = $slider->page_slider_images;
    		// $images = PageSliderImage::where('page_image_slider_id', Input::get('slider_id'))->get()->sortBy('sort_order');

			return Response::json(array('error' => false, 'images' => $images), 200);
		}

		return Response::json(array('error' => true, 'message' => 'Error processing request'), 422);
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
		$f = fopen('logs/slide.log', 'w+');
		fwrite($f, "updatePageSliderImage..\n\n". print_r(Input::all(), true));
		if(Request::ajax()) {
			if(Input::has('image_id') || Input::has('slide_id')) {
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
	    		if(Input::has('image_detail_de')) {
		    		$image->detail_de = Input::get('image_detail_de');
		    		$image->detail_en = Input::get('image_detail_en');
	    		}
	    		$image->url_de = Input::get('url_de');
	    		$image->url_en = Input::get('url_en');
	    		$image->active_de = Input::has('active_de') ? 1 : 0;
	    		$image->active_en = Input::has('active_en') ? 1 : 0;
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