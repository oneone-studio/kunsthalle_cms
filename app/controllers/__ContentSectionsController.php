<?php

class ContentSectionsController extends BaseController {

	public function index()
	{
		$content_sections = ContentSection::all();	
		// echo '<pre>'; print_r($content_sections); exit;
		return View::make('pages.content_sections.index', ['content_sections' => $content_sections]);
	}

	public function show()
	{
		// $events = Event::all();	

		return View::make('pages.content_sections.index');
	}

	public function create()
	{
		return View::make('pages.content_sections.create');
	}

	public function store()
	{
		$input = Input::all();
		// echo '<pre>'; print_r($input); exit;
		$content_section = new ContentSection();
		$content_section->title_de = Input::get('title_de');
		$content_section->title_en = Input::get('title_en');
		// $content_section->sort_order = Input::get('sort_order');
		// $content_section->active = Input::get('active');
		$content_section->save();

        return Redirect::action('ContentSectionsController@index');
	}

	public function edit($id)
	{
		$content_section = ContentSection::findOrFail($id);

		return View::make('pages.content_sections.edit', [ 'content_section' => $content_section ]);
	}

	public function update()
	{

		$content_section = ContentSection::findOrFail(Input::get('id'));

		$content_section->title_de = Input::get('title_de');
		$content_section->title_en = Input::get('title_en');
		$content_section->sort_order = Input::get('sort_order');
		$content_section->active = Input::get('active');
		$content_section->save();

        return Redirect::action('ContentSectionsController@index');
	}
	
	public function destroy($id) {
		ContentSection::where('id', $id)->delete();

		return Redirect::action('ContentSectionsController@index');
	}
}
