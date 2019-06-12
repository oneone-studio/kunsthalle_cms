<?php

class KEventsController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'EventController@showWelcome');
	|
	*/

	public function index()
	{
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('/login');
		}
		$log = "\nListing events";
		$events = KEvent::all()->sortByDesc('start_date');	
		foreach($events as &$e) {
			$cluster_arr = [];
			if($e->clusters) {
				foreach($e->clusters as $cl) {
					$cluster_arr[] = '<a href="/content/clusters/edit/'.$cl->id.'" target="_blank">'.$cl->title_de.'</a>';
				}
			}
			$e->cluster_arr = $cluster_arr;
		}
		LogHelper::logcms($log);

		return View::make('pages.k_events.index', ['events' => $events] );
	}

	public function show()
	{
		// $events = Event::all();	

		return View::make('pages.k_events.index');
	}

	public function create()
	{
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('/login');
		}
		$log = "\nCreating event";

		$exhibitions = Exhibition::all();
		$tags = Tag::all();
		$events = KEvent::all();	
		$exhibitions_arr = [];
		foreach($exhibitions as $ex) {
			$exhibitions_arr[$ex->id] = $ex->title;
		}	
		$weekdays = [ 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday' ];
		$clusters = Cluster::all();
		LogHelper::logcms($log);

		return View::make('pages.k_events.create', ['exhibitions' => $exhibitions_arr, 'weekdays' => $weekdays, 'tags' => $tags,
													'events' => $events, 'clusters' => $clusters]);
	}

	public function edit($id)
	{
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('/login');
		}
		$log = "\nEditing event\nInputs: ". print_r(Input::all(), true);
		$k_event = KEvent::with(['tags', 'entrance', 'kEventCost', 'event_dates'])->find($id);
		$tags = Tag::all();
		$events = KEvent::all();	
		if(!isset($k_event->entrance)) {
			$ent = new Entrance();
			$ent->free = 0;
			$ent->included = 0;
			$ent->excluded = 0;
			$ent->entry_fee = 0;
			$ent->save();
			$k_event->entrance()->save($ent);
			$k_event->save();
		}
		// echo '<pre>'; print_r($k_event); 			exit;

		if(!isset($k_event->kEventCost)) {
			$cost = new kEventCost();
			$cost->k_event_id = $k_event->id;
			$cost->regular_adult_price = 0;
			$cost->regular_child_price = 0;
			$cost->member_adult_price = 0;
			$cost->member_child_price = 0;
			$cost->reduced_price = 0;
			$cost->sibling_child_price = 0;
			$cost->sibling_member_price = 0;
			$cost->inclusive_material = 0;
			$cost->entry_fee = 0;
			$cost->save();

			$k_event->kEventCost()->save($cost);
			$k_event->save();
		}

		$k_event->start_date = date('d/m/Y', strtotime($k_event->start_date));
		$k_event->end_date = date('d/m/Y', strtotime($k_event->end_date));
		$k_event->start_time = substr($k_event->start_time, 0, 5);
		$k_event->end_time = strlen(trim($k_event->end_time)) > 0 ? substr($k_event->end_time, 0, 5) : '';

		$exhibitions = Exhibition::all();
		$exhibitions_arr = [];
		foreach($exhibitions as $ex) {
			$exhibitions_arr[$ex->id] = $ex->title;
		}	

		$page_links = []; // Select page link
		$mn_items = MenuItem::all()->sortBy('sort_order');
		$page_sections = [];
		$normal_pages = [];
		$pg_secs = [];
		foreach($mn_items as &$mi) {
			$mi_title = $mi->slug_de;
			$c_secs = ContentSection::where('menu_item_id', $mi->id)
								->where('active_de', 1)
								->where('type', 'page_section')->get();
			// Section pages
			if($c_secs) {
				foreach($c_secs as $sec) {
					// $sec_title = str_replace(' ', '-', strtolower($sec->title_en));
					$sec_title = $sec->slug_de;
					$list = Page::where('content_section_id', $sec->id)->where('active_de', 1)->get();
					$sec_link = Config::get('vars.domain').'de/'.$mi_title.'/'.$sec_title;
					if($list) {
						$pages = [];
						foreach($list as $pg) {
							$pg_slug = $pg->slug_de;
							$link = Config::get('vars.domain').'de/sb-page/'.$mi_title.'/'.$sec_title.'/'.$pg_slug;
							$pages[] = [ 'title' => $pg->title_de, 'link' => $link ];
						}
						if(count($pages) > 0) {
							$page_sections[] = [ 'title' => $sec->title_de, 'link' => $sec_link, 'pages' => $pages ];
						}
					}
				}
			}	
			// // Normal pages
			$c_secs = ContentSection::where('menu_item_id', $mi->id)
						->where('type', 'page')
						->where('active_de', 1)
						->get();
			if($c_secs) {
				foreach($c_secs as $sec) {
					$list = Page::where('content_section_id', $sec->id)							
							->where('page_type', 'normal')->where('active_de', 1)->get();
					if($list) {
						$pages = [];
						foreach($list as $pg) {
							$pg_slug = $pg->slug_de;
							$link = Config::get('vars.domain').'de/'.$mi_title.'/'.$pg_slug;
							$pages[] = ['id' => $pg->id, 'title' => $pg->title_de, 'link' => $link];
						}
						if(count($pages) > 0) {
							$normal_pages[] = [ 'title' => $mi_title, 'pages' => $pages ];
						}
					}
				}
			}
		}
		// Exb
		$exb_pages = [];
		$query = 'select p.* from pages p 
		          where page_type = "exhibition" 
		          group by p.id';
		$results = DB::select($query);
		if($results) {
			foreach($results as $pg) {
				$pg_slug = $pg->slug_de;
				$link = Config::get('vars.domain').'de/view/exhibitions/exb-page/'.$pg_slug;
				$exb_pages[] = ['title' => $pg->title_de, 'link' => $link];
			}
		}

		$page_links['page_sections'] = $page_sections;
		$page_links['normal_pages'] = $normal_pages;
		$page_links['exb_pages'] = $exb_pages;
		// echo '<pre>'; print_r($exb_pages); exit;		
		// echo '<pre>'; print_r($page_links); exit;		

		$weekdays = [ 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday' ];
		$data = [ 'k_event' => $k_event, 'exhibitions' => $exhibitions_arr, 'weekdays' => $weekdays, 'tags' => $tags, 
				  'events' => $events, 'page_links' => $page_links ];

		LogHelper::logcms($log);

		return View::make('pages.k_events.edit', $data);
	}

	public function update()
	{		
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('/login');
		}
		$log = "\nUpdating event\nInputs: ". print_r(Input::all(), true);

		$id = Input::get('id');
		// $query = 'update k_events set place = "'. htmlentities(Input::get('place')).'" where id = '. $id;		
		$evt = KEvent::with('event_dates', 'kEventCost')->find($id);
		// echo htmlentities(Input::get('detail_de')); exit;
		$evt->title_de = Input::get('title_de');
		$evt->title_en = Input::get('title_en');
		$evt->subtitle_de = Input::get('subtitle_de');
		$evt->subtitle_en = Input::get('subtitle_en');
		$evt->detail_de = htmlentities(Input::get('detail_de'));
		$evt->detail_en = Input::get('detail_en');
		$evt->caption_de = Input::get('caption_de');
		$evt->caption_en = Input::get('caption_en');
		$startDate = str_replace('/', '-', Input::get('start_date'));
		$evt->start_date = date('Y-m-d', strtotime($startDate));
		$endDate = str_replace('/', '-', Input::get('end_date'));
		if(!Input::has('has_random_dates')) {
			$evt->end_date = date('Y-m-d', strtotime($endDate));
			$evt->has_random_dates = 0;
		} else {
			$evt->has_random_dates = 1;
		}
		$evt->end_date = date('Y-m-d', strtotime($endDate));
		$evt->end_time = strlen(trim(Input::get('end_time'))) > 0 ? Input::get('end_time') : '';
		$evt->start_time = Input::get('start_time');
		$evt->end_time = Input::get('end_time');
		$event_day = Input::get('event_day');	
		$evt->event_day = $event_day;
		$event_day_repeat = Input::get('event_day_repeat');
		$evt->event_day_repeat = $event_day_repeat;
		$repeat_month = (Input::has('repeat_month')) ? Input::get('repeat_month') : '';
		$evt->repeat_month = $repeat_month;
		if(!empty($event_day) && !empty($event_day_repeat)) {
			DB::table('event_dates')->where('k_event_id', '=', $id)->delete();
		}
		$evt->registration_detail = Input::get('registration_detail');
		// $evt->has_random_dates = isset(Input::get('has_random_dates')) ? Input::get('has_random_dates') : false;
		// $evt->event_dates = Input::get('event_dates');	
		$e_dates = [];
		if(count($evt->event_dates) > 0) {
			$evt->event_day = '';
			$evt->event_day_repeat = '';
			foreach($evt->event_dates as $ed) { $e_dates[] = $ed->event_date; }
			usort($e_dates, function($x, $y) {
				if(strtotime($x) == strtotime($y)) return 0;
				return (strtotime($x) < strtotime($y)) ? -1 : 1;
			});
			$today = strtotime(date('Y-m-d'));
			$_dates = [];
			foreach($e_dates as $edt) {
				if(strtotime($edt) < $today) { $rem_dates[] = $edt; }
				else { $_dates[] = $edt; }
			}
			$e_dates = $_dates;
			if(count($e_dates) > 0) { 
				$evt->start_date = $e_dates[0];
				$evt->end_date = $e_dates[count($e_dates)-1];
			}

		} else {
			$rep_dates = KEventsController::getEventRepeatDates($evt->id, $evt->start_date, $evt->event_day, $event_day_repeat, $repeat_month, $evt->end_date);
			    // echo 'Start date: '. $evt->start_date .'<br>End Date: '. $evt->end_date.'<br>Event Day: '. $event_day.'<br>Event Day Repeat: '. $evt->event_day_repeat.'<br>Repeat Month: '. $repeat_month . '<br><pre>dt '; print_r($rep_dates); exit;

			if(is_array($rep_dates) && count($rep_dates)) {
				$evt->start_date = $rep_dates[0];
				$evt->end_date = end($rep_dates);
			}
		}

		$page_url = Input::get('page_url');
		if(strlen(Input::get('page_url_1')) > 1) {
			$page_url = Input::get('page_url_1');
		} else if(strlen(Input::get('page_url_2')) > 1) {
			$page_url = Input::get('page_url_2');
		} else if(strlen(Input::get('page_url_3')) > 1) {
			$page_url = Input::get('page_url_3');
		}
		$has_page_link = strlen(trim($page_url)) > 0 ? true : false;
		
		$page_link_title = Input::has('page_link_title') ? htmlentities(Input::get('page_link_title')) : '';
		if(strlen($page_link_title) && $page_link_title[0].$page_link_title[1] == '- ') { $page_link_title = substr($page_link_title, 2, strlen($page_link_title)); }
		if($has_page_link) {
			$evt->page_link = $page_url;
			$page_link_title = trim(str_replace('[np]', '', $page_link_title));
			$page_link_title = trim(str_replace('[sp]', '', $page_link_title));
			$page_link_title = trim(str_replace('[ep]', '', $page_link_title));
			$evt->page_link_title = $page_link_title;
		} else {
			$evt->page_link = '';
			$evt->page_link_title = '';			
		}
		$evt->page_link_text = Input::get('page_link_text');

		$evt->page_link_text = Input::get('page_link_text');
		$evt->guide_name = Input::get('guide_name');
		$evt->as_series = Input::has('as_series') ? 1 : 0;
		$evt->show_after_startdate = Input::has('show_after_startdate') ? 1 : 0;
		$place = Input::get('place');
		$place = htmlentities($place);
		// $str = utf8_encode(htmlspecialchars($street));
		$evt->place = $place;
		$evt->building_number = Input::get('building_number');
		$map_url = Input::get('google_map_url');
		if(strlen($map_url) > 0 && !strstr($map_url, 'http://')) { $map_url = 'http://'. $map_url; }
		$evt->google_map_url = $map_url;
		$evt->remarks = Input::get('remarks');

		$evt->registration = Input::get('registration');
		$evt->max_attendance = Input::get('max_attendance');
		$evt->members_only = Input::get('members_only');
		$evt->first_only = (Input::has('first_only')) ? 1 : 0;
		// $evt->is_free = Input::get('is_free');

		if(is_numeric($evt->kEventCost->id) && $evt->kEventCost->id > 0) {
			$cost = KEventCost::find($evt->kEventCost->id);
		}	
		if(!isset($cost)) {
			$cost = new kEventCost();
			$cost->k_event_id = $evt->id;
		}
		
		$ent = $evt->entrance;
		$ent->free = Input::get('free') ? 1 : 0;
		$ent->included = Input::get('included') ? 1 : 0;
		$ent->excluded = Input::get('excluded') ? 1 : 0;
		$ent->entry_fee = Input::get('entry_fee') ? 1 : 0;
		$ent->save();
		$evt->entrance()->save($ent);
		// echo $evt->entrance->free; exit;		

		if(strlen(trim(Input::get('regular_adult_price'))) > 0 && floatval(Input::get('regular_adult_price')) >= 0) {
			$regular_adult_price = str_replace(',', '.', Input::get('regular_adult_price'));
			// $regular_adult_price = str_pad(substr($regular_adult_price, 0, strpos($regular_adult_price, '.')), 2, '0', STR_PAD_LEFT); //. '.00';
			if(strpos($regular_adult_price, '.')) { $regular_adult_price = substr($regular_adult_price, 0, strpos($regular_adult_price, '.')); }
		} else {
			$regular_adult_price = '';
		}

		if(strlen(trim(Input::get('regular_child_price'))) > 0 && floatval(Input::get('regular_child_price')) >= 0) {
			$regular_child_price = str_replace(',', '.', Input::get('regular_child_price'));
			// $regular_child_price = str_pad(substr($regular_child_price, 0, strpos($regular_child_price, '.')), 2, '0', STR_PAD_LEFT); //. '.00';
			if(strpos($regular_child_price, '.')) { $regular_child_price = substr($regular_child_price, 0, strpos($regular_child_price, '.')); }
		} else {
			$regular_child_price = '';
		}

		if(strlen(trim(Input::get('member_adult_price'))) > 0 && floatval(Input::get('member_adult_price')) >= 0) {
			$member_adult_price = str_replace(',', '.', Input::get('member_adult_price'));
			// $member_adult_price = str_pad(substr($member_adult_price, 0, strpos($member_adult_price, '.')), 2, '0', STR_PAD_LEFT); //. '.00';
			if(strpos($member_adult_price, '.')) { $member_adult_price = substr($member_adult_price, 0, strpos($member_adult_price, '.')); }
		} else {
			$member_adult_price = '';
		}

		if(strlen(trim(Input::get('member_child_price'))) > 0 && floatval(Input::get('member_child_price')) >= 0) {
			$member_child_price = str_replace(',', '.', Input::get('member_child_price'));
			// $member_child_price = str_pad(substr($member_child_price, 0, strpos($member_child_price, '.')), 2, '0', STR_PAD_LEFT); //. '.00';
			if(strpos($member_child_price, '.')) { $member_child_price = substr($member_child_price, 0, strpos($member_child_price, '.')); }
		} else {
			$member_child_price = '';
		}

		if(strlen(trim(Input::get('sibling_child_price'))) > 0 && floatval(Input::get('sibling_child_price')) >= 0) {
			$sibling_child_price = str_replace(',', '.', Input::get('sibling_child_price'));
			// $sibling_child_price = str_pad(substr($sibling_child_price, 0, strpos($sibling_child_price, '.')), 2, '0', STR_PAD_LEFT); //. '.00';
			if(strpos($sibling_child_price, '.')) { $sibling_child_price = substr($sibling_child_price, 0, strpos($sibling_child_price, '.')); }
		} else {
			$sibling_child_price = '';
		}

		if(strlen(trim(Input::get('sibling_member_price'))) > 0 && floatval(Input::get('sibling_member_price')) >= 0) {
			$sibling_member_price = str_replace(',', '.', Input::get('sibling_member_price'));
			// $sibling_member_price = str_pad(substr($sibling_member_price, 0, strpos($sibling_member_price, '.')), 2, '0', STR_PAD_LEFT); //. '.00';
			if(strpos($sibling_member_price, '.')) { $sibling_member_price = substr($sibling_member_price, 0, strpos($sibling_member_price, '.')); }
		} else {
			$sibling_member_price = '';
		}

		if(strlen(trim(Input::get('reduced_price'))) > 0 && floatval(Input::get('reduced_price')) >= 0) {
			$reduced_price = str_replace(',', '.', Input::get('reduced_price'));
			// $sibling_member_price = str_pad(substr($sibling_member_price, 0, strpos($sibling_member_price, '.')), 2, '0', STR_PAD_LEFT); //. '.00';
			if(strpos($reduced_price, '.')) { $reduced_price = substr($reduced_price, 0, strpos($reduced_price, '.')); }
		} else {
			$reduced_price = '';
		}

		// echo $regular_adult_price.'<br>'.$regular_child_price.'<br>'.$member_adult_price.'<br>'.$member_child_price.'<br>'.$sibling_member_price.'<br>'.$sibling_child_price;exit;
		$cost->regular_adult_price = $regular_adult_price;
		$cost->regular_child_price = $regular_child_price;
		$cost->member_adult_price = $member_adult_price;
		$cost->member_child_price = $member_child_price;
		$cost->sibling_child_price = $sibling_child_price;
		$cost->sibling_member_price = $sibling_member_price;

		$cost->reduced_price = $reduced_price;

		$cost->inclusive_material = Input::has('inclusive_material') ? 1 : 0;
		$cost->entry_fee = Input::get('entry_fee') ? 1 : 0;
		$cost->save();			

		$evt->kEventCost()->save($cost);

		$exhibition_ids = [];
		$exbs = [];
		$e_ids = Input::get('exhibitions');
		if(!is_array($e_ids)) {
			$exhibition_ids[] = $e_ids;
		} else {
			$exhibition_ids = $e_ids;
		}
		foreach($exhibition_ids as $id) {
			$exb = Exhibition::find($id);
			$exbs[] = $exb;
		}
		$evt->exhibitions()->sync($exhibition_ids);

		if(Input::has('tags') && count(Input::get('tags'))) {
			$evt->tags()->sync(Input::get('tags')); // attach tags
		} else {
		    $evt->tags()->detach(); // detatch tags
		}

		$evt->save();

		LogHelper::logcms($log);

        return Redirect::action('KEventsController@edit', ['id' => $evt->id]);
	}

	public function updateEventDates()
	{		
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('/login');
		}
		$log = "\nUpdating event\nInputs: ". print_r(Input::all(), true);

		$id = Input::get('id');
		$evt = KEvent::with('event_dates')->find($id);
		if(Input::has('event_date')) {
			$event_date = date('Y-m-d', strtotime(str_replace('/', '-', Input::get('event_date'))));

			$eds = EventDate::where('k_event_id', '=', $id)->where('event_date', '=', $event_date)->get();
			if(!$eds || !count($eds)) {
				$ed = new EventDate();
				$ed->event_date = $event_date;			
				$ed->save();			
				$evt->event_dates()->save($ed);
			}

			$evt->event_day = '';
			$evt->event_day_repeat = '';

			$start_date = $evt->start_date;
			$start = strtotime($start_date);
			$end_date = $evt->end_date;			
			$end = strtotime($end_date);

			$edates = EventDate::where('k_event_id', '=', $id)->get();
			$event_date_list = [];	
			foreach($edates as $edate) {
				$event_date_list[] = strtotime($edate->event_date);
			}
			asort($event_date_list); // sort array by value
			
			$sortedDates = [];
			$evt = KEvent::with('event_dates')->find($id);
			$elist = $evt->event_dates;

			foreach($event_date_list as $l) {
				foreach($elist as $el) {
					$eln = strtotime($el->event_date);
					if($l == $eln) {
						$sortedDates[] = [ 'id' => $el->id, 'event_date' => date('d/m/Y', $l) ];
					}
				}
			}

			if(count($event_date_list)) {
				$start = $event_date_list[0];
				$end = end($event_date_list);
			}

			$evt->start_date = date('Y-m-d', $start);
			$evt->end_date = date('Y-m-d', $end);;
			$evt->save();

			$evt = KEvent::with('event_dates')->find($id);
			$evt->sortedEventDates = $sortedDates;

			return Response::json(array('error' => false, 'event' => $evt), 200);
		}
		LogHelper::logcms($log);

		return Response::json(array('error' => true, 'message' => 'Error updating data'), 422);
	}	


	public function deleteEventDate()
	{		
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('/login');
		}

		$log = "\nDeleting event date\nInputs: ". print_r(Input::all(), true);

		$id = Input::get('id');
		if(is_numeric($id)) {
			DB::table('event_dates')->where('id', '=', $id)->delete();

			$eid = Input::get('event_id');
			$evt = KEvent::with('event_dates')->find($eid);
			$edates = EventDate::where('k_event_id', '=', $eid)->get();
			$event_date_list = [];	
			foreach($edates as $edate) {
				$event_date_list[] = strtotime($edate->event_date);
			}
			asort($event_date_list); // sort array by value
			
			$sortedDates = [];
			$elist = $evt->event_dates;

			foreach($event_date_list as $l) {
				foreach($elist as $el) {
					$eln = strtotime($el->event_date);
					if($l == $eln) {
						$sortedDates[] = [ 'id' => $el->id, 'event_date' => date('d/m/Y', $l) ];
					}
				}
			}
			$evt->sortedEventDates = $sortedDates;

			return Response::json(array('error' => false, 'event' => $evt), 200);
		}

		return Response::json(array('error' => true, 'message' => 'Error updating data'), 422);

	}
		
	public function deleteKEvents() {
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('/login');
		}

		$log = "\nDeleting event(s)\nInputs: ". print_r(Input::all(), true);
		// if(Request::ajax()) {
			if(Input::has('id')) {
				$ids = Input::get('id');
				KEvent::destroy($ids);
		
				return Redirect::action('KEventsController@index');
			}
		// }
		LogHelper::logcms($log);

		return Redirect::action('KEventsController@index');
	}
	
	public function destroy($id) {
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('/login');
		}

		$log = "\nDeleting event(s)\Id: ". $id;
		$event = KEvent::find($id);
		$event->delete();
		LogHelper::logcms($log);

		return Redirect::action('KEventsController@index');
	}
	
	public function delPageLink() {
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('/login');
		}
		$log = "\nDeleting page link\nInputs: ". print_r(Input::all(), true);

		if(Input::has('id')) {
			DB::table('k_events')->where('id', Input::get('id'))->update(['page_link' => '', 'page_link_title' => '']);
			LogHelper::logcms($log);
			return Response::json(array('error' => false), 200);
		}
		LogHelper::logcms($log);

		return Response::json(array('error' => true), 400);
	}

	public function store()
	{
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('/login');
		}
		$log = "\nSaving event\nInputs: ". print_r(Input::all(), true);

		$input = Input::all();
		// echo '<pre>'; print_r($input); exit;
		$evt = new KEvent;
		$evt->title_de = Input::get('title_de');
		$evt->title_en = Input::get('title_en');
		$evt->subtitle_de = input::get('subtitle_de');
		$evt->subtitle_en = Input::get('subtitle_en');
		$evt->detail_de = Input::get('detail_de');
		$evt->detail_en = Input::get('detail_en');
		$evt->as_series = Input::has('as_series') ? 1 : 0;
		$evt->show_after_startdate = Input::has('show_after_startdate') ? 1 : 0;
		$evt->place = htmlentities(Input::get('place'));

		$evt->guide_name = Input::get('guide_name');
		$evt->registration = Input::get('registration');
		$evt->registration_detail = Input::get('registration_detail');
		$evt->max_attendance = Input::get('max_attendance');
		$evt->members_only = Input::get('members_only');
		
		$cost = new KEventCost();
		$cost->regular_adult_price = Input::get('regular_adult_price');
		$cost->regular_child_price = Input::get('regular_child_price');
		$cost->member_adult_price = Input::get('member_adult_price');
		$cost->member_child_price = Input::get('member_child_price');
		$cost->reduced_price = Input::get('reduced_price');
		$cost->sibling_child_price = Input::get('sibling_child_price');
		$cost->sibling_member_price = Input::get('sibling_member_price');
		$evt->remarks = Input::get('remarks');
		$map_url = Input::get('google_map_url');
		if(strlen($map_url) > 0 && !strstr($map_url, 'http://')) { $map_url = 'http://'. $map_url; }
		$evt->google_map_url = $map_url;
		$cost->inclusive_material = Input::has('inclusive_material') ? 1 : 0;
		// $cost->entry_fee = Input::get('entry_fee') ? 1 : 0;
		$cost->save();
		// $evt->k_event_cost_id = $cost->id;
		$evt->save();
		$evt->kEventCost()->save($cost);

		$ent = new Entrance();
		$ent->free = Input::get('free') ? 1 : 0;
		$ent->included = Input::get('included') ? 1 : 0;
		$ent->excluded = Input::get('excluded') ? 1 : 0;
		$ent->entry_fee = Input::get('entry_fee') ? 1 : 0;
		$ent->save();
		$evt->entrance()->save($ent);

		$exhibition_ids = [];
		$exbs = [];
		if(Input::has('exhibitions')) {
			$e_ids = Input::get('exhibitions');
			if(!is_array($e_ids)) {
				$exhibition_ids[] = $e_ids;
			} else {
				$exhibition_ids = $e_ids;
			}
			foreach($exhibition_ids as $id) {
				$exb = Exhibition::find($id);
				$exbs[] = $exb;
			}
			if(count($exhibition_ids) > 0) {
				$evt->exhibitions()->sync($exhibition_ids);
			}
		}
		if(Input::has('tags') && count(Input::get('tags'))) {
			$evt->tags()->sync(Input::get('tags')); // attach tags
		} else {
		    $evt->tags()->detach(); // detatch tags
		}
		$evt->save();
		LogHelper::logcms($log);
		
        return Redirect::action('KEventsController@edit', ['id' => $evt->id]);
	}

	public function upload() {
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('/login');
		}
		$log = "\nUploading image\nInputs: ". print_r(Input::all(), true);

		if(Request::ajax()) {
			if (Input::hasFile('k_event_image')) {
				$file = Input::file('k_event_image');
	    		$file->move('files/events', $file->getClientOriginalName());

	    		$event = KEvent::find(Input::get('id'));
	    		$event->event_image = 'files/events/' . $file->getClientOriginalName();
	    		$event->save();
				LogHelper::logcms($log);

				return Response::json(array('error' => false, 'item' => '/'.$event->event_image), 200);
			}
		}
		LogHelper::logcms($log);

		return Response::json(array('error' => true, 'message' => 'Error creating product'), 422);
	}

	public function deleteEventImage() {
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('/login');
		}
		$log = "\nDeleting image\nInputs: ". print_r(Input::all(), true);

		if(Request::ajax()) {
			if (Input::has('id')) {
	    		$event = KEvent::find(Input::get('id'));
	    		$event->event_image = '';
	    		$event->save();
				LogHelper::logcms($log);

				return Response::json(array('error' => false, 'item' => $event), 200);
			}
		}
		LogHelper::logcms($log);

		return Response::json(array('error' => true, 'message' => 'Failed to handle request'), 422);
	}

	public function duplicate() {
		if(!AuthHelper::checkUser()) {
			Auth::logout();
			Session::forget('auth');
			return Redirect::to('/login');
		}
		$log = "\nDuplicating event image\nInputs: ". print_r(Input::all(), true);

		if(Request::ajax()) {
			if(Input::has('id')) {
				$k_event = KEvent::with(['tags', 'entrance', 'kEventCost', 'event_dates'])->find(Input::get('id'));
				$new_event = $k_event->replicate();
				$new_event->push();
				$event_dates = $k_event->event_dates;
				foreach($event_dates as $ed) {
					$dt = $ed->replicate();
					$dt->k_event_id = $new_event->id;
					$new_event->event_dates()->save($dt);
				}

				$kEventCost = $k_event->kEventCost->replicate();
				$entrance = $k_event->entrance->replicate();
				$new_event->kEventCost()->save($kEventCost);
				$new_event->entrance()->save($entrance);
				$new_event->save();
				LogHelper::logcms($log);

				return Response::json(array('error' => false, 'id' => $new_event->id), 200);
			}
		}
		LogHelper::logcms($log);

		return Response::json(array('error' => true, 'message' => 'Error creating product'), 422);
	}

	public function getexbs() {
		$id = Input::get('id');
		$evt = KEvent::find($id);

		$data = KEvent::getExhibitionIds($id);
		$exbs = $evt->exhibitions();

		return Response::json( $data);
	}

	public function test() {
		return View::make('pages.k_events.test');
	}

	public function multiselectTmpl() {
		return View::make('includes.multiselect-tmpl');
	}


	// Find dates for repeated event
	public static function getEventRepeatDates($id, $start_date, $event_day, $event_day_repeat, $repeat_month = 0, $end_date) {
		$rep_dates = [];
		$range = [];
		// echo $start_date . ' --- ' . $end_date; exit;
		$event_day_repeat = strtolower($event_day_repeat);
		switch($event_day_repeat) {
			case 'daily': $rep_dates = KEventsController::getDailyEventRepDates($start_date, $end_date, $event_day, $repeat_month);
			              break;
			case 'every': $rep_dates = KEventsController::getRepDates($start_date, $end_date, $event_day, $repeat_month);
			              break;
			case 'every first': $rep_dates = KEventsController::getEventFirstDayDates($start_date, $end_date, $event_day, $repeat_month);
			              		break;
			case 'every second': $rep_dates = KEventsController::getEventSecondDayDates($start_date, $end_date, $event_day, $repeat_month);
			              		break;
			case 'every third': $rep_dates = KEventsController::getEventThirdDayDates($start_date, $end_date, $event_day, $repeat_month);
			              		break;
			case 'every last': $rep_dates = KEventsController::getEventLastDayDates($start_date, $end_date, $event_day, $repeat_month);
			              		break;
			case 'bi-weekly': $rep_dates = KEventsController::getEventBiWeeklyDates($start_date, $end_date, $event_day);
			              		break;
		}
		// if(count($rep_dates)) { echo '<pre>'; print_r($rep_dates); exit; }	

		return $rep_dates;
	}

	// Find event dates based on Daily
	public static function getDailyEventRepDates($start, $end, $event_day, $repeat_month = 0) {
	    $rep_dates = [];
	    $_rep_dates[] = $start;
	    $dates = array($start);
	    $months = [];
        $month = date('n', strtotime($start));
        $months[] = $month;        
        for($i=0; $i<20; $i++) {
        	$month += $repeat_month;
        	if($month > 12) { $month -= 12; }
        	if(!in_array($month, $months)) { $months[] = intval($month); }
        }
	    while(end($dates) < $end) {
	        $date = date('Y-m-d', strtotime(end($dates).' +1 day'));
	        $dates[] = $date;
	        $_rep_dates[] = $date;
	    }
	    $rep_dates = [];
	    foreach($_rep_dates as $d) {
	    	$m = date('m', strtotime($d));
	    	// if(in_array($m, $months)) { 
	    		$rep_dates[] = $d; 
	    	// }
	    }

	    return $rep_dates;
	}

	// Find event dates based on every Tuesday..
	public static function getRepDates($start, $end, $rep_day, $repeat_month = 0) {
	    $rep_dates = [];
	    $dates = array(date('Y-m-d', strtotime($start.' -1 day')));
	    $start_month = date('m', strtotime($start));
	    $months = [];
	    while(end($dates) < $end) {
	        $date = date('Y-m-d', strtotime(end($dates).' +1 day'));
	        $dates[] = $date;
	        $day = date('l', strtotime($date));
	        $month = date('m', strtotime($date));
	        $last_month = 0;
	        if(count($months)) { $last_month = end($months); }
        	if($month == $start_month || $repeat_month == 0 || $repeat_month == 1 || ($repeat_month == 3 && ($last_month+3 == $month))) {
		        if($day == $rep_day) {
			        $rep_dates[] = $date; //date('j.n', strtotime($date)); 
			        $months[] = $month;
		        }
		    }    
	    }
	    // echo implode(', ', $rep_dates); echo '<br><br>'; exit;

	    return $rep_dates;
	}

	// Find dates for event on e every first Tuesday/Wednesday ..
	public static function getEventFirstDayDates($start, $end, $rep_day, $repeat_month = 0) {
	    $rep_dates = [];
	    $dates = array(date('Y-m-d', strtotime($start.' -1 day'))); // $start);
	    // print_r($dates);exit;
	    $start_month = date('m', strtotime($start));
	    $months = [];
	    while(end($dates) < $end) {
	        $date = date('Y-m-d', strtotime(end($dates).' +1 day'));
	        $dates[] = $date;
	        $day = date('l', strtotime($date));
	        $dayOfMonth = date('d', strtotime($date));
	        $month = date('m', strtotime($date));
	        $last_month = 0;
	        if(count($months)) { $last_month = end($months); }
        	if($month == $start_month || $repeat_month == 0 || $repeat_month == 1 || ($repeat_month == 3 && ($last_month+3 == $month))) {
		        if($day == $rep_day && !in_array($month, $months) && $dayOfMonth < 8) {
			        $rep_dates[] = $date;
			        $months[] = $month;
	        	} 
	        }
	    }
	    // echo implode(', ', $rep_dates); echo '<br><br>'; exit;

	    return $rep_dates;
	}

	// Find dates for event on e every second Tuesday/Wednesday ..
	public static function getEventSecondDayDates($start, $end, $rep_day, $repeat_month = 0) {
	    $rep_dates = [];
	    // $dates = array($start);
	    $dates = array(date('Y-m-d', strtotime($start.' -1 day')));
	    $start_month = date('m', strtotime($start));
		$date = date('Y-m-d', strtotime($start));
	    $months = [];
	    $dayCount = 0;
	    while(end($dates) < $end) {
	        $dates[] = $date;
	        $day = date('l', strtotime($date));
	        $dayOfMonth = date('d', strtotime($date));
	        $month = date('m', strtotime($date));
	        // echo $date . ', ';
	        // if($month == $startMonth && ($dayOfMonth > 7)) { $dayCount = 1; }
	        if($day == $rep_day && ($dayOfMonth > 7 && $dayOfMonth <= 14)) {
	        	if($month == $start_month || $repeat_month == 0 || $repeat_month == 1 || ($repeat_month == 3 && ($last_month+3 == $month))) {
		        	if(!in_array($month, $months)) {
				        $rep_dates[] = $date;
				        $months[] = $month;
				        $dayCount = 0;
		        	}
	        	} 
	        }
	        $date = date('Y-m-d', strtotime(end($dates).' +1 day'));
	    }
	    // echo implode(', ', $rep_dates); echo '<br><br>'; exit;

	    return $rep_dates;
	}

	// Find event dates based on third event
	public static function getEventThirdDayDates($start, $end, $rep_day, $repeat_month = 0) {
	    $rep_dates = [];
	    // $dates = array($start);
	    $dates = array(date('Y-m-d', strtotime($start.' -1 day')));
	    $start_month = date('m', strtotime($start));
		$date = date('Y-m-d', strtotime($start));
	    $months = [];
	    $dayCount = 0;
	    while(end($dates) < $end) {
	        $dates[] = $date;
	        $month = date('m', strtotime($date));
	        $day = date('l', strtotime($date));
	        $dayOfMonth = date('d', strtotime($date));
	        // echo $date . ', ';
	        // if($month == $startMonth && ($dayOfMonth > 7)) { $dayCount = 1; }
	        $last_month = 0;
	        if(count($months)) { $last_month = end($months); }        	
		    if($day == $rep_day && ($dayOfMonth > 14 && $dayOfMonth <= 21)) {
		    	if($month == $start_month || $repeat_month == 0 || $repeat_month == 1 || ($repeat_month == 3 && ($last_month+3 == $month))) {
			        $rep_dates[] = $date;
			        $dayCount = 0;
		        	if(!in_array($month, $months)) {
				        $months[] = $month;
		        	}
		        }	
	        }
	        $date = date('Y-m-d', strtotime(end($dates).' +1 day'));
	    }
	    // echo 'Dates: '. implode(', ', $rep_dates); echo '<br><br>'; exit;

	    return $rep_dates;
	}

	// Find dates for event on e every last Tuesday/Wednesday ..
	public static function getEventLastDayDates($start, $end, $rep_day, $repeat_month = 0) {
	    $rep_dates = [];
	    $dates = array($start);
		$start_month = date('m', strtotime($start));	    
		$date = date('Y-m-d', strtotime($start));
	    $months = [];
	    $dayCount = 0;
	    while(end($dates) < $end) {
	        $dates[] = $date;
	        $day = date('l', strtotime($date));
	        $dayOfMonth = date('d', strtotime($date));
	        $month = date('m', strtotime($date));
	        $last_month = 0;
	        if(count($months)) { $last_month = end($months); }
        	if($month == $start_month || $repeat_month == 0 || $repeat_month == 1 || ($repeat_month == 3 && ($last_month+3 == $month))) {
		        if($day == $rep_day && ($dayOfMonth >= 23)) {
		        	$forceEntry = false;
		        	if($day == $rep_day && ($dayOfMonth >= 23)) {
		        		$forceEntry = true;
		        	}
		        	if(!in_array($month, $months) || $forceEntry) {
		        		foreach($rep_dates as $k => $dt) {
		        			$ar = explode('-', $dt);
		        			if($ar[1] == $month) {
		        				array_splice($rep_dates, $k, 1);
		        			}
		        		}
				        $rep_dates[] = $date;
				        if(!in_array($month, $months)) {
					        $months[] = $month;
				        }
				        $dayCount = 0;
		        	}
		        }
		    }  
	        $date = date('Y-m-d', strtotime(end($dates).' +1 day'));
	    }
	    // echo implode(', ', $rep_dates); echo '<br><br>'; exit;

	    return $rep_dates;
	}
	
	// Find dates for event on bi-weekly basis .. Tuesday/Wednesday ..
	public static function getEventBiWeeklyDates($start, $end, $rep_day) {
	    $rep_dates = [];
	    $dates = array($start);
		$startMonth = date('m', strtotime($start));	    
		$date = date('Y-m-d', strtotime($start));
	    $months = [];
	    $matchCount = 0;
	    while(end($dates) < $end) {
	        $dates[] = $date;
	        $day = date('l', strtotime($date));
	        $dayOfMonth = date('d', strtotime($date));
	        $month = date('m', strtotime($date));
	        if($day == $rep_day) {
	        	++$matchCount;
	        }
	        if($day == $rep_day && $matchCount == 1) {
		        $rep_dates[] = $date;
	        }
	        if($matchCount > 1) {
	        	$matchCount = 0;
	        }
	        $date = date('Y-m-d', strtotime(end($dates).' +1 day'));
	    }
	    // echo implode(', ', $rep_dates); echo '<br><br>'; exit;

	    return $rep_dates;
	}

}
