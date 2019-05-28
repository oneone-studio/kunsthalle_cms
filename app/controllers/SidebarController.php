<?php

class SidebarController extends BaseController {

	public function index()
	{
		$sidebar = [ 
		    'general' => [
				'Clusters' 				=> '/content/clusters',
				'Events'				=> '/content/events',
				'Start Page'		   	=> '/pages/edit-start-page',
				'Tags'					=> '/content/tags',
				'Departments'			=> '/content/departments',
				'Contacts'  			=> '/content/contacts',
				'Exhibitions'  			=> '/content/exhibition-pages',
				'Footer'			    => '/content/footer-pages',
				'Redirects'  			=> '/content/redirects',
				'Settings'  			=> '/content/settings',
		    ]
		];

		$content_sections = ContentSection::with('pages')->get();	

		return View::make('includes.sidebar', ['sidebar' => $sidebar]);
	}

	public static function getSidebar() {
		$sidebar = [ 
		    'general' => [
				'Clusters' 				=> '/content/clusters',
				'Events'				=> '/content/events',
				'Start Page'		   	=> '/pages/edit-start-page',
				'Tags'					=> '/content/tags',
				'Departments'			=> '/content/departments',
				'Contacts'  			=> '/content/contacts',
				'Exhibitions'  			=> '/content/exhibition-pages',
				'Footer'			    => '/content/footer-pages',
				'Redirects'  			=> '/content/redirects',
				'Settings'  			=> '/content/settings',
		    ]
		];

		$sidebar['menu_items'] = [];
		$menu_items = MenuItem::with(['content_sections'])->orderBy('sort_order')
						->where('id', '!=', 2)
						->get();
		foreach($menu_items as $mi) {
			$content_sections = ContentSection::with('pages')->where('menu_item_id', $mi->id)->orderBy('sort_order')->get();
			$cs_links = [];
			foreach($content_sections as $cs) {
				$cs_links[] = $cs; 
			}		
			$sidebar['menu_items'][] = [
						   'menu_item'    => $mi,
						   'content_sections' => $cs_links
						];
		}		
		// echo '<pre>'; print_r($sidebar); exit;
		return $sidebar;
	}

}
