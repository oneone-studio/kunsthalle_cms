<?php

class PageSliderImagesExbController extends BaseController {

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

        return Redirect::action('ExhibitionPagesController@edit', ['id' => $page_id]);
	}

	public function savePageSliderImage() {
		if(Request::ajax()) {
    		$slider = PageImageSlider::with(['page_slider_images'])->find(Input::get('slider_id'));
    		$order = 1;
    		if(isset($slider->page_slider_images)) {
    			foreach($slider->page_slider_images as $img) {
    				$img->sort_order = $img->sort_order + 1;
    				$img->save();
    			}
    		}
    		$image = null;
    		if(Input::has('slider_image_id') && (int)Input::get('slider_image_id') > 0) {
				$image = PageSliderImage::find(Input::get('slider_image_id'));
    		} else {
	    		$image = new PageSliderImage();
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
    		$image->text_position = Input::get('position');
    		$image->sort_order = 1;
    		$image->save();

    		$slider->page_slider_images()->save($image);
    		$slider = PageImageSlider::with('page_slider_images')->find(Input::get('slider_id'));
    		$images = $slider->page_slider_images;
    		// $images = PageSliderImage::where('page_image_slider_id', Input::get('slider_id'))->get()->sortBy('sort_order');

			return Response::json(array('error' => false, 'images' => $images), 200);
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
				$image = PageSliderImage::find(Input::get('id'));

				return Response::json(array('error' => false, 'image' => $image), 200);
			}
		}

		return Response::json(array('error' => true, 'message' => 'Error processing request'), 422);
	}

	public function updatePageSliderImage() {
		if(Request::ajax()) {
			if(Input::has('image_id')) {
				$filename = '';
				if(Input::hasFile('gallery_image')) {
					$file = Input::file('gallery_image');
					$filename = $file->getClientOriginalName();
					$file = Input::file('gallery_image');
		    		$file->move('files/sliders', $filename);
				}
				$image = PageSliderImage::find(Input::get('image_id'));

				if(strlen($filename) > 0) {
		    		$image->filename = $filename;
				}
	    		$image->detail = Input::get('image_detail');
	    		$image->sort_order = 1;
	    		$image->save();

				return Response::json(array('error' => false, 'item' => $image), 200);
			}
		}

		return Response::json(array('error' => true, 'message' => 'Error creating product'), 422);
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