<?php

class PageSectionsController extends BaseController {

	public function index()
	{
	}

	public static function adjustSortOrder($page_id = 0, $item_id = 0, $type = null, $sort_order = 0) {
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			// return Redirect::to('/login');
			return Redirect::to('http://www.google.com');
		}

		$cur_sort_order = $sort_order;
		$types = ['content', 'gallery'];
		if($type != null) {
			// find current sort order of item
			$query = "select sort_order from page_sections where page_id = ".$page_id." and ".$type."_id = ". $item_id;
			$ps_res = DB::select($query);
			if(is_array($ps_res) && count($ps_res)) {
				$cur_sort_order = $ps_res[0]->sort_order;
			}

			$min_order = $sort_order;
			$max_order = $cur_sort_order;
			if($cur_sort_order < $sort_order) {
				$min_order = $cur_sort_order;
				$max_order = $sort_order;
			}

			if(in_array($type, $types) && ($min_order != $max_order)) {
				PageSection::where('page_id', $page_id)
							 ->where($type.'_id', $item_id)
							 ->update(['sort_order' => $sort_order]);
				$ps_res = PageSection::where('page_id', $page_id)
									   ->where('sort_order', '>=', $min_order)
									   ->where('sort_order', '<=', $max_order)
									   ->orderBy('sort_order')
									   ->get();
				if($cur_sort_order > $sort_order) {
					foreach($ps_res as $ps) {
						if($ps->{$type.'_id'} != $item_id) {
							$ps->sort_order = intval($ps->sort_order) + 1;
							$ps->save();
						}
					}					   
				} elseif($cur_sort_order < $sort_order) {
					foreach($ps_res as $ps) {
						if($ps->{$type.'_id'} != $item_id) {
							$ps->sort_order = intval($ps->sort_order) - 1;
							$ps->save();
						}		
					}					   
				}

				$query = "select content_id, gallery_id, sort_order from page_sections where page_id = ".$page_id . " order by sort_order";
				$ps_res = DB::select($query);
				if(is_array($ps_res)) {
					foreach($ps_res as $ps) {
						if($ps->content_id > 0) {
							PageContent::where('id', $ps->content_id)->update(['sort_order' => $ps->sort_order]);
						}	
						if($ps->gallery_id > 0) {
							PageImageSlider::where('id', $ps->gallery_id)->update(['sort_order' => $ps->sort_order]);
						}	
					}
				}
			}
		}
	}

	public function moveUp($menu_item_id = 0, $cs_id = 0, $page_id = 0, $ps_id = 0) {
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			// return Redirect::to('/login');
			return Redirect::to('http://www.google.com');
		}

		$log = "\nPage id: ".$page_id . "\nSection id: ". $ps_id;
		$ps = PageSection::find($ps_id);
		if($ps) {
			$old_order = $ps->sort_order;
			if(($old_order - 1) > 0) {
				$ps2 = PageSection::where('sort_order', ($old_order-1))
						->where('page_id', $page_id)
						->get();
				if($ps2) {
					$ps->sort_order = ($old_order-1);
					$ps->save();
					$ps2[0]->sort_order = $old_order;
					$ps2[0]->save();
				}
			}
		}	
		$log .= "\nPage section moved down.";
		LogHelper::logcms($log);

        return Redirect::action('PagesController@edit', ['menu_item_id' => $menu_item_id, 'cs_id' => $cs_id, 'id' => $page_id]);
	}

	public function moveDown($menu_item_id = 0, $cs_id = 0, $page_id = 0, $ps_id = 0) {
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('http://www.google.com');
		}

		$log = "\nPage id: ".$page_id . "\nSection id: ". $ps_id;
		$ps_list = PageSection::where('page_id', $page_id)->get();
		$ps = PageSection::find($ps_id);
		if($ps) {
			$old_order = $ps->sort_order;
			if(($old_order + 1) <= (count($ps_list))) {
				$ps2 = PageSection::where('sort_order', ($old_order+1))
						->where('page_id', $page_id)
						->get();
				if($ps2) {
					$ps->sort_order = ($old_order+1);
					$ps->save();
					$ps2[0]->sort_order = $old_order;
					$ps2[0]->save();
				}
			}
		}	
		$log .= "\nPage section moved down.";
		LogHelper::logcms($log);

        return Redirect::action('PagesController@edit', ['menu_item_id' => $menu_item_id, 'cs_id' => $cs_id, 'id' => $page_id]);
	}

	public function deletePageSection($menu_item_id = 0, $cs_id = 0, $page_id = 0, $ps_id = 0, $item_id = 0, $type = null, $red_action = null) {
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			// return Redirect::to('/login');
			return Redirect::to('http://www.google.com');
		}

		if($ps_id > 0) {
			$ps = PageSection::find($ps_id);
			$old_order = $ps->sort_order;		
		
			$log = "\nPage id: ".$page_id;

			PageSection::where('id', $ps_id)->delete();
			$items = PageSection::where('page_id', $page_id)->where('sort_order', '>', $old_order)->get();
			foreach($items as $item) {
				$item->sort_order = intval($item->sort_order) - 1;
				$item->save();
			}
		}
		if($type == 'content') {
			PageContent::where('id', $item_id)->delete();
			PageSection::where('content_id', $item_id)->delete();
		}
		if($type == 'slider') {
			PageSliderImage::where('page_image_slider_id', $item_id)->delete();
			PageImageSlider::where('id', $item_id)->delete();
			PageSection::where('gallery_id', $item_id)->delete();
		}
		if($type == 'h2') {
			H2::where('id', $item_id)->delete();
			PageSection::where('h2_id', $item_id)->delete();
		}
		if($type == 'h2text' || $type == 'h2_text') {
			H2text::where('id', $item_id)->delete();
			PageSection::where('h2_text_id', $item_id)->delete();
		}
		if($type == 'image') {
			Image::where('id', $item_id)->delete();
			PageSection::where('image_id', $item_id)->delete();
		}
		if($type == 'youtube') {
			Image::where('id', $item_id)->delete();
			PageSection::where('youtube_id', $item_id)->delete();
		}
		if($type == 'audio') {
			Image::where('id', $item_id)->delete();
			PageSection::where('audio_id', $item_id)->delete();
		}

		$this->resetPSSort($page_id);

		$log .= "\n".$type." deleted";
		if(isset($red_action)) {
			if($red_action == 'exb-page') {
				return Redirect::action('ExhibitionPagesController@edit', ['id' => $page_id]);
			}
		}

		if($menu_item_id > 0) {
	        return Redirect::action('PagesController@edit', ['menu_item_id' => $menu_item_id, 'cs_id' => $cs_id, 'id' => $page_id]);
		} else {
			return Redirect::action('ExhibitionPagesController@edit', [$page_id]);
		}
	}

	public function resetPSSort($page_id) {
		// Re-index
		$query = 'select id, sort_order from page_sections where page_id = '.$page_id.' order by sort_order';
		$res = DB::select($query);
		$indx = 0;
		foreach($res as $r) {
			++$indx;
			if($r->sort_order != $indx) {
				DB::table('page_sections')->where('id', $r->id)->update(['sort_order' => $indx]);				
			}
		}
	}

	public function getPageSection($sec, $id) {
		$item = [];
		if($sec == 'h2') {
			$item = H2::find($id);
		}
		if($sec == 'h2text') {
			$item = H2text::find($id);
		}

		return Response::json(array('error' => false, 'page' => $page), 200);
	}
}
